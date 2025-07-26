<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--front-zise -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #F9FAFB;
            font-family: 'Nunito';
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        .mb-4 {
            color: #4f46e5;
        }

        .btn-primary {
            background-color: #4f46e5;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" style="max-width: 480px; width: 100%;">
            <h1 class="text-primary mb-4"> Mot de passe oublié</h1>

            <!-- Message de confirmation simulé -->
            <div class="alert alert-success d-none" id="statusBox">
                Code envoyé avec succès.
            </div>


            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.code.send') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Envoyer le code
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (si tu ajoutes des animations/modales plus tard) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
