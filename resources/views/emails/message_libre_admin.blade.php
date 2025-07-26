<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Prévisualisation du message</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            padding: 2rem;
            color: #212529;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
        }

        h2 {
            font-size: 1.5rem;
            color: #343a40;
            margin-bottom: 1rem;
        }

        .content {
            white-space: pre-line;
            font-size: 1rem;
            line-height: 1.5;
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            text-align: center;
        }

        .back-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.875rem;
            background-color: #6c757d;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-button i {
            margin-right: 0.4rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Message à {{ $nom }}</h2>
        <div class="content">{!! nl2br(e($contenu)) !!}</div>

        <div class="footer">
            Ce message a été envoyé via le système <strong>DAARASGEO</strong>.
        </div>

        @if (isset($utilisateur))
            <a href="{{ route('admin.utilisateurs.edit', $utilisateur->id) }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour à l’utilisateur
            </a>
        @endif
    </div>
</body>

</html>
