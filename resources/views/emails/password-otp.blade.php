<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MarketLink password reset</title>
</head>
<body style="margin:0;background:#f4faf7;font-family:Arial,Helvetica,sans-serif;color:#17342d;">
<div style="max-width:620px;margin:30px auto;padding:0 16px;">
    <div style="background:#073b34;border-radius:22px 22px 0 0;padding:24px 28px;color:#fff;">
        <div style="font-size:24px;font-weight:800;">Market<span style="color:#fbbf24;">Link</span></div>
        <div style="margin-top:5px;color:#a7c9bf;font-size:13px;">Account security</div>
    </div>
    <div style="background:#fff;border:1px solid #dceae4;border-top:0;border-radius:0 0 22px 22px;padding:30px 28px;">
        <p style="font-size:16px;">Hello {{ $name }},</p>
        <p style="font-size:16px;line-height:1.65;">You requested to reset your MarketLink password. Use this one-time verification code:</p>
        <div style="margin:24px 0;text-align:center;">
            <span style="display:inline-block;padding:16px 25px;border:1px solid #d7e9e0;background:#f4faf7;border-radius:16px;font-size:32px;line-height:1;letter-spacing:8px;font-weight:800;color:#12815c;">{{ $otp }}</span>
        </div>
        <p style="font-size:14px;color:#65786f;line-height:1.6;">This code expires in <strong>10 minutes</strong> and can be used once. If you did not request a password reset, you can safely ignore this message.</p>
        <hr style="border:0;border-top:1px solid #e8efeb;margin:25px 0;">
        <p style="margin:0;font-size:12px;color:#8a9b94;">MarketLink · Local markets, made simple.</p>
    </div>
</div>
</body>
</html>
