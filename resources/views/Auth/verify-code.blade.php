<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vérification du code - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f6faff;
            padding: 2rem;
        }

        .verify-box {
            max-width: 460px;
            margin: auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
        }

        .btn-indigo {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            border: none;
        }

        .btn-indigo:hover {
            background-color: #3b39d4;
        }

        .alert-danger {
            max-width: 460px;
            margin: auto;
            padding: 2rem;
            background-color: #4f46e5;
            color: red;
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
            width: 100%;
            margin: 60px auto 40px auto;
        }
    </style>
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Votre code est invalide</strong>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="verify-box">
        <h1 class="text-center text-indigo mb-4"style="color: #4f46e5;">Vérification du code</h1>



        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.code.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <div class="mb-3">
                <input type="text" name="code" class="form-control" placeholder="Entrer votre code" required>
            </div>
            <button type="submit" class="btn btn-indigo w-100">
                Valider le code
            </button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
