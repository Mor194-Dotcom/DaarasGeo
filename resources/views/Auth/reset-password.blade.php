<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5faff;
            margin: 0;
            padding: 0;
        }

        .reset-box {
            max-width: 440px;
            margin: 60px auto;
            padding: 2.5rem;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
        }

        .reset-box h4 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #3b3b3b;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .mb-4 {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 150px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            cursor: pointer;

        }

        .btn-primary {
            background-color: #4f46e5;
            /* Indigo */
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .btn-secondary {
            background-color: #4f46e5;
            /* Gray */
        }

        .btn-secondary:hover {
            background-color: #6b7280;
        }


        .text-danger {
            font-size: 0.85rem;
        }

        .alert-danger {
            background-color: #4f46e5;
            color: rgba(246, 28, 28, 1);

        }
    </style>
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{!! nl2br(e($error)) !!}</li> <!-- nl2br pour gérer le saut de ligne -->
                @endforeach
            </ul>
        </div>
    @endif


    <div class="reset-box">
        <h4 class="text-center">Réinitialiser votre mot de passe</h4>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="code" value="{{ $code }}">


            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" autocomplete="new-password"
                    required minlength="8">
                <span class="text-danger d-none">Le mot de passe est trop court</span>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    autocomplete="new-password" required>
                <span class="text-danger d-none">La confirmation ne correspond pas</span>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary w-100 py-2">
                    Réinitialiser
                </button>
                <a href="{{ route('login') }}" class="btn btn-secondary">Annuler</a>
            </div>

        </form>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
