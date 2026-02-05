<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$subject}}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f2f4f6; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h2 style="color: #333; margin: 0;">{{$subject}}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 16px; color: #555; margin: 0 0 15px;">Hi {{ $voter->FirstName . " " . $voter->LastName }},</p>
                            <p style="font-size: 16px; color: #555; margin: 0 0 20px;">
                                Use the OTP below to sign in to your account.
                            </p>

                            <div style="text-align: center; margin: 30px 0;">
                                <div style="display: inline-block; background-color: #f0fff7; padding: 15px 30px; border-radius: 8px;">
                                    <span style="font-size: 28px; font-weight: bold; color: #3db272;">{{ $otp }}</span>
                                </div>
                            </div>

                            <p style="font-size: 14px; color: #999; text-align: center;">
                                This OTP will expire in 5 minutes.
                            </p>

                            <p style="font-size: 14px; color: #999; margin-top: 30px;">
                                If you did not request this, you can safely ignore this message.
                            </p>

                            <p style="font-size: 16px; color: #555; margin-top: 30px;">
                                Best regards,<br>
                                {{ config('app.name') }}-MIS Team
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 12px; color: #aaa; margin-top: 20px;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>