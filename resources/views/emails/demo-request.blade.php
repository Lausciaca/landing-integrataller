<x-email.layout :preheader="'Nuevo pedido de demo de ' . $contact->taller">
    <h1 style="margin:0 0 16px; font-size:28px; line-height:36px; font-weight:700; color:#0B2A5B;">Nuevo pedido de demo</h1>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:16px; line-height:24px;">
        @foreach ([
            'Nombre' => $contact->name,
            'Taller' => $contact->taller,
            'Email' => $contact->email,
            'Teléfono' => $contact->phone,
            'Consulta' => $contact->message ?: 'Sin comentario adicional.',
            'Pidió recibir novedades' => $contact->marketing_opt_in_requested ? 'Sí; falta confirmar el email.' : 'No.',
        ] as $label => $value)
            <tr>
                <td style="padding:10px 0; border-bottom:1px solid #D5DCE8; width:40%; color:#4A5870; font-size:14px; vertical-align:top;">{{ $label }}</td>
                <td style="padding:10px 0; border-bottom:1px solid #D5DCE8; vertical-align:top;"><strong style="font-weight:500;">{{ $value }}</strong></td>
            </tr>
        @endforeach
    </table>
</x-email.layout>
