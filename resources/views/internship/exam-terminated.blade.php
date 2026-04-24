<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Terminated — Innovative IT Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin:0; padding:0; background:#070719; color:#fff; font-family:'Outfit',sans-serif;
               display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .term-box { background:rgba(13,13,38,0.8); border:1px solid #dc2626; border-radius:20px;
                    padding:50px; text-align:center; max-width:500px; box-shadow:0 20px 60px rgba(220,38,38,0.2); }
        .term-icon { font-size:4rem; color:#dc2626; margin-bottom:24px; }
        h1 { font-weight:800; font-size:2rem; margin:0 0 16px; }
        p { color:#9ca3af; line-height:1.6; margin-bottom:30px; font-weight:400; }
        .btn { background:#dc2626; color:#fff; padding:12px 30px; font-weight:700;
               border-radius:50px; text-decoration:none; display:inline-block; }
    </style>
</head>
<body>
    <div class="term-box">
        <div class="term-icon"><i class="fas fa-ban"></i></div>
        <h1>Exam Terminated</h1>
        <p>Your exam was terminated because our system detected a violation of the rules (tab switching, window minimizing, or focus loss). As per our policy, your application has been automatically failed.</p>
        <p style="font-size:0.9rem">You may re-apply for the internship program after 30 days.</p>
        <a href="{{ route('internship.landing') }}" class="btn">Return to Home</a>
    </div>
</body>
</html>
