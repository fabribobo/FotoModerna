<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Completa il pagamento - {{ $eventName }}</title>
</head>

<body
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f3f4f6; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(15,23,42,0.1);">
                    <tr>
                        <td style="background-color: #1d4ed8; padding: 20px 24px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 20px;">Completa il pagamento</h1>
                            <p style="margin: 4px 0 0; font-size: 14px; opacity: 0.9;">{{ $eventName }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px; color: #111827; font-size: 15px; line-height: 1.5;">
                            <p>Ciao {{ $leadName }},</p>
                            <p>
                                grazie per aver scelto il nostro studio fotografico per l'evento
                                <strong>{{ $eventName }}</strong>.
                            </p>
                            <p>
                                Per ricevere le tue foto, completa il pagamento di
                                <strong>{{ number_format($amount, 2, ',', '.') }} &euro;</strong> cliccando sul
                                pulsante qui sotto:
                            </p>
                            <p style="text-align: center; margin: 24px 0;">
                                <a href="{{ $paymentUrl }}"
                                    style="display: inline-block; padding: 12px 24px; background-color: #1d4ed8; color: #ffffff; text-decoration: none; border-radius: 9999px; font-weight: 600; font-size: 14px;">
                                    Paga ora
                                </a>
                            </p>
                            <p style="font-size: 14px; color: #4b5563;">
                                Puoi completare il pagamento anche nei prossimi giorni: il link resta valido per 30
                                giorni. Riceverai il link per scaricare le foto subito dopo il pagamento.
                            </p>
                            <p style="font-size: 14px; color: #4b5563;">
                                Se il pulsante non dovesse funzionare, copia e incolla questo indirizzo nel tuo browser:
                            </p>
                            <p style="font-size: 13px; color: #1d4ed8; word-break: break-all;">
                                {{ $paymentUrl }}
                            </p>
                            <p style="margin-top: 16px;">Un saluto,<br><strong>Fotomoderna</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding: 16px 24px; background-color: #f3f4f6; color: #6b7280; font-size: 12px; text-align: center;">
                            Questa email contiene un link personale. Per la tua privacy, ti consigliamo di non
                            condividerlo pubblicamente.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
