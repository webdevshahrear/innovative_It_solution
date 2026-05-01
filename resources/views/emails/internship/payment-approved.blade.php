<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #0f172a; margin-top: 0;">Hi {{ $application->full_name }},</h2>
        
        <p style="color: #334155; font-size: 16px; line-height: 1.6;">
            Great news! Your bKash payment for the security deposit has been manually verified and approved by our team.
        </p>

        <p style="color: #334155; font-size: 16px; line-height: 1.6;">
            Your spot in the <strong>Innovative IT Solutions Internship Program</strong> is now secured. You are just one step away from accessing your dashboard and starting your journey with us.
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $registrationLink }}" style="background-color: #f05223; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;">
                Set Up Intern Account
            </a>
        </div>

        <p style="color: #64748b; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
            If the button doesn't work, you can copy and paste the following link into your browser:<br>
            <a href="{{ $registrationLink }}" style="color: #3b82f6; word-break: break-all;">{{ $registrationLink }}</a>
        </p>

        <p style="color: #64748b; font-size: 14px; margin-top: 20px;">
            Best regards,<br>
            <strong>Innovative IT Solutions Team</strong>
        </p>
    </div>
</body>
</html>
