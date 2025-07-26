{{-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur DaarasGeo</title>

    <!-- Fonts + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: url('{{ asset('assets/img/bg-map.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            max-width: 800px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .welcome-logo {
            max-height: 100px;
            margin-bottom: 20px;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0d6efd;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #495057;
            margin-top: 10px;
            font-weight: 600;
        }

        .welcome-description {
            font-size: 1.05rem;
            color: #6c757d;
            margin-top: 20px;
            line-height: 1.6;
        }

        .welcome-buttons .btn {
            min-width: 160px;
            font-size: 1rem;
            font-weight: 600;
            padding: 10px 20px;
        }

        .welcome-footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

            .welcome-buttons .btn {
                min-width: 180px;
                font-size: 1rem;
                font-weight: 600;
                padding: 12px 24px;
                border-radius: 50px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .welcome-buttons .btn-outline-primary:hover {
                background-color: #0d6efd;
                color: white;
                border-color: #0d6efd;
            }

            .welcome-buttons .btn-primary {
                background: linear-gradient(135deg, #0d6efd, #6610f2);
                border: none;
                color: white;
            }

            .welcome-buttons .btn-primary:hover {
                background: linear-gradient(135deg, #6610f2, #0d6efd);
                box-shadow: 0 6px 16px rgba(13, 110, 253, 0.3);
            }

        }

        .welcome-buttons {
            animation: fadeUp 0.8s ease-in-out;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="welcome-wrapper">
        <!-- Logo -->
        <img src="{{ asset('assets/img/logo6.png') }}" alt="Logo DaarasGeo" class="welcome-logo">

        <!-- Titre -->
        <div class="welcome-title">DaarasGeo</div>
        <div class="welcome-subtitle">La technologie au service des Talibés <br><strong>Sheutul Saab Ndooga </strong>
        </div>

        <!-- Description -->
        <p class="welcome-description">
            DaarasGeo est une plateforme intelligente dédiée à la géolocalisation, au suivi et à la sécurisation des
            enfants Talibés dans les Daaras.
            Elle permet aux responsables, tuteurs et administrateurs de visualiser les déplacements, recevoir des
            alertes, et garantir un encadrement éthique et sécurisé.
        </p>

        <!-- Boutons -->
        <div class="welcome-buttons mt-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </a>
            <a href="{{ route('sign-up') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i> Créer un compte
            </a>
        </div>


        <!-- Footer -->
        <div class="welcome-footer">
            © {{ date('Y') }} DaarasGeo — Tous droits réservés
        </div>
    </div>

    <!-- SB Admin JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
 --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur DaarasGeo</title>

    <!-- Fonts + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: url('{{ asset('assets/img/image2.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
            z-index: -1;
        }

        .welcome-wrapper {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(0px);
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            max-width: 800px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .welcome-logo {
            max-height: 100px;
            margin-bottom: 20px;
            animation: floatLogo 3s ease-in-out infinite;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0d6efd;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #495057;
            margin-top: 10px;
            font-weight: 600;
        }

        .text-gradient {
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .welcome-description {
            font-size: 1.05rem;
            color: #6c757d;
            margin-top: 20px;
            line-height: 1.6;
        }

        .welcome-buttons .btn {
            min-width: 180px;
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-buttons .btn:hover {
            transform: translateY(-2px);
        }

        .welcome-buttons .btn:active {
            transform: scale(0.98);
        }

        .welcome-buttons .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .welcome-buttons .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            color: white;
        }

        .welcome-buttons .btn-primary:hover {
            background: linear-gradient(135deg, #6610f2, #0d6efd);
            box-shadow: 0 6px 16px rgba(13, 110, 253, 0.3);
        }

        .welcome-buttons {
            animation: fadeUp 0.8s ease-in-out;
        }

        .welcome-footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatLogo {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .welcome-wrapper {
                padding: 40px 20px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .welcome-description {
                font-size: 0.95rem;
            }

            .welcome-buttons .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="welcome-wrapper">
        <!-- Logo -->
        <img src="{{ asset('assets/img/logo6.png') }}" alt="Logo DaarasGeo" class="welcome-logo">

        <!-- Titre -->
        <div class="welcome-title">DaarasGeo</div>
        <div class="welcome-subtitle">
            La technologie au service des Talibés <br>
            <strong class="text-gradient">Shaaytul Saab Ndooga Daara</strong>
        </div>

        <!-- Description -->
        <p class="welcome-description">
            DaarasGeo est une plateforme intelligente dédiée à la géolocalisation, au suivi et à la sécurisation des
            enfants Talibés dans les Daaras.
            Elle permet aux responsables, tuteurs et administrateurs de visualiser les déplacements, recevoir des
            notifications a declanchement des alertes, et garantir un encadrement éthique et sécurisé.
        </p>

        <!-- Boutons -->
        <div class="welcome-buttons mt-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </a>
            <a href="{{ route('sign-up') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i> Créer un compte
            </a>
        </div>

        <!-- Footer -->
        <div class="welcome-footer">
            © {{ date('Y') }} DaarasGeo — Tous droits réservés
        </div>
    </div>

    <!-- SB Admin JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
