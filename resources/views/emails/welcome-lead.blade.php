<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8fafc; padding-bottom: 40px; }
        .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: 40px; }
        .header { background: linear-gradient(135deg, #f05223 0%, #ff7b54 100%); padding: 40px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.02em; }
        .content { padding: 40px; color: #334155; line-height: 1.6; }
        .content h2 { color: #0f172a; font-size: 20px; font-weight: 700; margin-top: 0; }
        .btn { display: inline-block; background: #f05223; color: #ffffff !important; padding: 14px 30px; border-radius: 12px; font-weight: 700; text-decoration: none; margin-top: 20px; box-shadow: 0 5px 15px rgba(240, 82, 35, 0.3); }
        .footer { padding: 30px; text-align: center; background-color: #f1f5f9; color: #64748b; font-size: 13px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <div class="header">
                <h1>Innovative IT</h1>
            </div>
            <div class="content">
                <h2>Hello {{ $lead->name }},</h2>
                <p>Thank you for reaching out to **Innovative IT Solutions**. We've successfully received your inquiry regarding "<strong>{{ $lead->subject }}</strong>".</p>
                <p>Our strategic team is currently reviewing your mission requirements. We pride ourselves on rapid deployment and high-impact solutions, and one of our experts will be in touch with you within the next 24 hours.</p>
                <p>In the meantime, feel free to explore our latest digital transformations in our portfolio.</p>
                <a href="{{ url('/portfolio') }}" class="btn">View Our Portfolio</a>
                <p style="margin-top: 30px;">Best Regards,<br><strong>Innovative IT Team</strong></p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} Innovative IT Solutions. All rights reserved.<br>
                Dhaka, Bangladesh — Digital Agency Excellence.
            </div>
        </div>
    </div>
</body>
</html>
