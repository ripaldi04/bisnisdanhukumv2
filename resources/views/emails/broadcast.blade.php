<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bisnis dan Hukum | {{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #FFD700;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #FFD700;
            margin: 0;
            font-size: 24px;
        }

        .content {
            margin-bottom: 30px;
        }

        .footer {
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Bisnis dan Hukum</h1>
            <h2>{{ $title }}</h2>
        </div>

        <div class="content">
            {!! $content !!}
        </div>

        <div class="footer">
            <p>Terima kasih telah menjadi bagian dari Bisnis dan Hukum</p>
            <p>&copy; 2026 Bisnis dan Hukum. All rights reserved.</p>
            <p>Jika Anda tidak ingin menerima email ini, silakan abaikan pesan ini.</p>
        </div>
    </div>
</body>

</html>
