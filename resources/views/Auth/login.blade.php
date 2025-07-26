{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Nunito + FontAwesome + Animate.css
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #4f46e5, #6c5ce7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-attachment: fixed;
        }

        .login-container {
            max-width: 540px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
        }

        .input-field {
            width: 85%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #ccc;
            border-left: 5px solid transparent;
            border-radius: 10px;
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
            transition: border-left-color 0.4s ease, box-shadow 0.3s ease;
        }

        .input-field::placeholder {
            color: #aaa;
            font-style: italic;
        }

        .input-field:focus {
            outline: none;
            border-left-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #4f46e5;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            width: 85%;
            border-radius: 10px;
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.7s;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-message {
            font-size: 0.85rem;
            color: #e63946;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <div class="login-container animate__animated animate__fadeIn">
        <h2 class="text-2xl font-bold text-indigo-600 text-center mb-2">
            <i class="fas fa-map-marked-alt me-2"></i> Connexion
        </h2>
        <p class="text-sm text-gray-600 text-center mb-6">Accédez à votre tableau de bord DaarasGeo</p>

        @if (session('message'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 text-sm">
                {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-sm text-left">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="relative">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="input-field" placeholder="Adresse email..." required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="relative">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" class="input-field" placeholder="Mot de passe..." required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </button>
        </form>

        {{--   <p class="text-center text-sm text-gray-600 mt-5">
            Pas encore inscrit ? <a href="{{ route('sign-up') }}" class="text-indigo-600 hover:underline">Créer un
                compte</a>
        </p>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
 --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts + Icons + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--front-zise -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Nunito';
            background-color: #ffffffff;
        }

        .login-wrapper {
            display: flex;
            flex-direction: row;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .image-side {
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            padding: 50;
            margin: 25%;
        }

        .image-side img {
            max-width: 60%;
            height: 400px;
            transform: rotate(2deg);
        }

        .form-side {
            width: 70%;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 30px;
            padding: 0;
            background-color: #2f38e4ff;
        }

        .login-box {
            max-width: 400px;
            width: 100%;
            padding: 2rem;

            .login-box {
                background-color: #0e3cbcff;
                /* 💡 remplace par ta couleur souhaitée */
                border-radius: 16px;

                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            }

        }

        .btn-indigo {
            background-color: #ffffffff;
            color: blue;
            font-weight: bold;
            border-radius: 10px;
            border: none;
        }

        .btn-indigo:hover {
            background-color: #80958b20;
        }

        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .image-side {
                display: none;

            }

            .img-log {
                width: 100%;
                height: 100%;
            }

            .form-side {
                width: 100%;
            }
        }

        h1 {
            color: #ffffff;
        }

        .me-2 {
            max-height: 100px;
            max-width: 100px;
            border-radius: 150%;
        }

        .form-label {
            color: #ffffff;
        }

        .fw-semibold {
            color: #ffffff;
        }
    </style>
</head>

<body>
    @if (session('status'))
        <div class="alert alert-success text-center fade show">
            {{ session('status') }}
        </div>
    @endif


    <div class="login-wrapper">
        <!-- 📷 Image à gauche -->
        <div class="image-side">
            <img class="img-log" src="{{ asset('assets/img/imglogin.png') }}" alt="Illustration DaarasGeo">


            <!-- 🔐 Formulaire à droite -->
            <div class="form-side">
                <div class="login-box">
                    <div class="text-center text-indigo fw-bold mb-4">
                        <img class="me-2" src="assets/img/logo6.png" alt="img5">
                        <i class="me-1"></i>
                        <h1> Connexion
                        </h1>
                    </div>
                    @if (session('message'))
                        <div class="alert alert-success text-center small">{{ session('message') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" name="email" id="email" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('password.code.form') }}"
                            class="text-indigo text-decoration-none fw-semibold">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <p class="text-center text-muted mt-3 mb-0">

                        {{--    <a href="{{ route('sign-up') }}" class="text-indigo fw-semibold text-decoration-none">
                        Créer un compte
                    </a> --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
