{{-- Marco de email del manual: fondo gris-50, tarjeta blanca de 600px, logo horizontal color de 160px. --}}
@props(['preheader' => null])

<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>IntegraTaller</title>
</head>
<body style="margin:0; padding:0; background:#F4F6FA; font-family:Poppins,'Segoe UI','Helvetica Neue',Arial,sans-serif; color:#0F1B2D;">
    @if ($preheader)
        <div style="display:none; max-height:0; overflow:hidden;">{{ $preheader }}</div>
    @endif
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F6FA;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;">
                    <tr>
                        <td style="background:#FFFFFF; border-radius:16px 16px 0 0; padding:32px 32px 0;">
                            <img src="{{ asset('brand/logo-horizontal-color-2400.png') }}" width="160" alt="IntegraTaller" style="display:block; width:160px; height:auto; border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#FFFFFF; border-radius:0 0 16px 16px; padding:24px 32px 32px; font-size:16px; line-height:24px;">
                            {{ $slot }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px; font-size:14px; line-height:20px; color:#4A5870;">
                            IntegraTaller · Tu taller, en orden.<br>
                            <a href="{{ url('/') }}" style="color:#0A6E99;">{{ parse_url(url('/'), PHP_URL_HOST) }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
