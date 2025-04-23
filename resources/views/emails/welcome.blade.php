<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to MySecureVault</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
        }
        .content {
            padding: 30px 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #eee;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">MySecureVault</div>
        </div>
        <div class="content">
            <h2>Welcome, {{ $user->name }}!</h2>
            <p>Thank you for registering with MySecureVault. We're excited to have you on board!</p>
            <p>Your account has been successfully created, and you can now start uploading and managing your media files securely in one place.</p>
            
            <p>With MySecureVault, you can:</p>
            <ul>
                <li>Upload and store videos, audio, images, and documents</li>
                <li>Access your files from anywhere with internet access</li>
                <li>Manage your personal media library easily</li>
                <li>Play or view your media directly in your browser</li>
            </ul>
            
            <p>Get started by uploading your first file:</p>
            <a href="{{ url('/upload-form') }}" class="button">Upload Files</a>
            
            <p style="margin-top: 30px;">If you have any questions or need assistance, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>The MySecureVault Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} MySecureVault. All rights reserved.</p>
            <p>This email was sent to {{ $user->email }}</p>
        </div>
    </div>
</body>
</html> 