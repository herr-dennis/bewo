@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            color: #333;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

        .date {
            font-size: 20px;
            color: #5c2d91;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="logo">
        <img src="{{ asset('MediumSquareLogo.jpg') }}" alt="Schwarz&Web" width="120">
    </div>

    <div class="content">
        <p>Hallo{{" ".$name}},</p>
        <p>Eine neue Veranstaltung wurden von Bewo-Paiva geplant!:</p>
        <p class="date">Wann:{{ " ".Carbon::parse($datum)->format('d.m.Y ') }}</p>
        <p><strong>Nachricht:</strong> {!! $text !!}</p>
        <p>Ihre Zustimmung des Newsletters am: {{ Carbon::parse($consent_given_at)->format('d.m.Y H:i') }}</p>
    </div>

    <div class="footer">
        <p>Schwarz&Web – Einfach professionelle Webseiten</p>
    </div>
</div>
</body>
</html>
