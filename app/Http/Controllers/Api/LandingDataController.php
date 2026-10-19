<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;
use Illuminate\Validation\ValidationException;

class LandingDataController extends Controller
{
    public function demoRequests(Request $request): JsonResponse
    {
        $sync = $this->syncParameters($request);
        $query = Contact::query();

        $this->applySyncWindow($query, $sync['updated_since'], $sync['sync_until']);

        return $this->page($query, $sync, fn (Contact $contact) => [
            'id' => $contact->id,
            'name' => $contact->name,
            'workshop' => $contact->taller,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'message' => $contact->message,
            'status' => $contact->status,
            'marketing_opt_in_requested' => (bool) $contact->marketing_opt_in_requested,
            'source' => $contact->source,
            'created_at' => $contact->created_at?->toIso8601String(),
            'updated_at' => $contact->updated_at?->toIso8601String(),
        ]);
    }

    public function newsletterSubscribers(Request $request): JsonResponse
    {
        $sync = $this->syncParameters($request, allowStatus: true);
        $query = NewsletterSubscriber::query();

        if ($sync['status'] !== null) {
            $query->where('status', $sync['status']);
        }

        $this->applySyncWindow($query, $sync['updated_since'], $sync['sync_until']);

        return $this->page($query, $sync, fn (NewsletterSubscriber $subscriber) => [
            'id' => $subscriber->id,
            'email' => $subscriber->email,
            'status' => $subscriber->status,
            'source' => $subscriber->source,
            'consent_version' => $subscriber->consent_version,
            'consented_at' => $subscriber->consented_at?->toIso8601String(),
            'confirmed_at' => $subscriber->confirmed_at?->toIso8601String(),
            'unsubscribed_at' => $subscriber->unsubscribed_at?->toIso8601String(),
            'created_at' => $subscriber->created_at?->toIso8601String(),
            'updated_at' => $subscriber->updated_at?->toIso8601String(),
        ]);
    }

    public function unsubscribe(int $subscriberId): JsonResponse
    {
        $subscriber = NewsletterSubscriber::findOrFail($subscriberId);
        $changed = $subscriber->status !== 'unsubscribed';

        if ($changed) {
            $subscriber->fill([
                'status' => 'unsubscribed',
                'confirmation_token_hash' => null,
                'confirmation_expires_at' => null,
                'unsubscribe_token_hash' => null,
                'unsubscribed_at' => now(),
            ])->save();
        }

        return response()->json([
            'data' => [
                'id' => $subscriber->id,
                'email' => $subscriber->email,
                'status' => $subscriber->status,
                'unsubscribed_at' => $subscriber->unsubscribed_at?->toIso8601String(),
            ],
            'changed' => $changed,
        ]);
    }

    private function syncParameters(Request $request, bool $allowStatus = false): array
    {
        $rules = [
            'updated_since' => ['nullable', 'date'],
            'sync_until' => ['nullable', 'date'],
            'cursor' => ['nullable', 'string', 'max:2048'],
            'limit' => ['nullable', 'integer', 'between:1,100'],
        ];

        if ($allowStatus) {
            $rules['status'] = ['nullable', 'in:pending,active,unsubscribed'];
        }

        $validated = $request->validate($rules);

        if (isset($validated['cursor']) && ! isset($validated['sync_until'])) {
            throw ValidationException::withMessages([
                'sync_until' => 'Include the sync_until value returned with the previous page.',
            ]);
        }

        $cursor = isset($validated['cursor']) ? Cursor::fromEncoded($validated['cursor']) : null;
        if (isset($validated['cursor']) && $cursor === null) {
            throw ValidationException::withMessages(['cursor' => 'The cursor is invalid.']);
        }

        // The columns hold wall-clock times in the app timezone, so instants
        // sent with another offset (e.g. UTC) are converted before comparing.
        $timezone = config('app.timezone');
        $updatedSince = isset($validated['updated_since'])
            ? CarbonImmutable::parse($validated['updated_since'])->setTimezone($timezone)
            : null;
        $syncUntil = isset($validated['sync_until'])
            ? CarbonImmutable::parse($validated['sync_until'])->setTimezone($timezone)
            : CarbonImmutable::now($timezone);

        if ($updatedSince && $updatedSince->greaterThan($syncUntil)) {
            throw ValidationException::withMessages([
                'updated_since' => 'updated_since must be earlier than or equal to sync_until.',
            ]);
        }

        return [
            'cursor' => $cursor,
            'limit' => (int) ($validated['limit'] ?? 100),
            'status' => $validated['status'] ?? null,
            'sync_until' => $syncUntil,
            'updated_since' => $updatedSince,
        ];
    }

    private function applySyncWindow(Builder $query, ?CarbonImmutable $updatedSince, CarbonImmutable $syncUntil): void
    {
        if ($updatedSince) {
            $query->where('updated_at', '>=', $updatedSince);
        }

        $query->where('updated_at', '<=', $syncUntil)
            ->orderBy('updated_at')
            ->orderBy('id');
    }

    private function page(Builder $query, array $sync, callable $present): JsonResponse
    {
        $page = $query->cursorPaginate($sync['limit'], ['*'], 'cursor', $sync['cursor']);

        return response()->json([
            'data' => $page->getCollection()->map($present)->values(),
            'pagination' => [
                'limit' => $sync['limit'],
                'has_more' => $page->hasMorePages(),
                'next_cursor' => $page->nextCursor()?->encode(),
                'updated_since' => $sync['updated_since']?->toIso8601String(),
                'sync_until' => $sync['sync_until']->toIso8601String(),
            ],
        ]);
    }
}
