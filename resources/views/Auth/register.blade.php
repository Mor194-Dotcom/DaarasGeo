<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription - DaarasGeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Nunito + FontAwesome + Animate.css --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #4f46e5, #6c5ce7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-attachment: fixed;
        }

        .register-container {
            max-width: 640px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .input-style {
            width: 90%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #d1d5db;
            border-left: 5px solid transparent;
            border-radius: 10px;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            transition: border-left-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-style::placeholder {
            color: #888;
            font-style: italic;
        }

        .input-style:focus {
            outline: none;
            border-left-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .label-style {
            font-weight: 600;
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 4px;
            display: block;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            width: 90%;
            padding: 0.75rem;
            font-weight: bold;
            font-size: 1rem;
            border-radius: 10px;
            border: none;
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.6s;
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

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <div class="register-container animate__animated animate__fadeIn">
        <h2 class="text-2xl font-bold text-indigo-600 text-center mb-2">
            <i class="fas fa-user-plus me-2"></i> Inscription
        </h2>
        <p class="text-center text-sm text-gray-600 mb-6">Créez votre compte pour accéder à DaarasGeo</p>

        <form method="POST" action="{{ route('store.validate') }}">
            @csrf

            <div style="display: flex; gap: 1rem;">
                <div style="flex: 1;">
                    <label class="label-style">Nom</label>
                    <input type="text" name="nom" class="input-style" placeholder="Votre nom" required>
                </div>
                <div style="flex: 1;">
                    <label class="label-style">Prénom</label>
                    <input type="text" name="prenom" class="input-style" placeholder="Votre prénom" required>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div style="flex: 1;">
                    <label class="label-style">Adresse</label>
                    <input type="text" name="adresse" class="input-style" placeholder="Adresse complète" required>
                </div>
                <div style="flex: 1;">
                    <label class="label-style">Email</label>
                    <input type="email" name="email" class="input-style" placeholder="exemple@domain.com" required>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div style="flex: 1;">
                    <label class="label-style">Mot de passe</label>
                    <input type="password" name="password" class="input-style" placeholder="Créez un mot de passe"
                        required>
                </div>
                <div style="flex: 1;">
                    <label class="label-style">Confirmation</label>
                    <input type="password" name="password_confirmation" class="input-style" placeholder="Répétez-le"
                        required>
                </div>
            </div>

            <div>
                <label class="label-style">Rôle</label>
                <select name="role_enum_id" id="role_enum_id" onchange="afficherChampsSpecifiques()" class="input-style"
                    required>
                    <option disabled selected>-- Choisissez votre rôle --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" data-libelle="{{ $role->libelle }}">{{ $role->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tuteur -->
            <div id="champs_tuteur" class="hidden">
                <label class="label-style">Type de tuteur</label>
                <select name="type_tuteur" class="input-style">
                    @foreach (\App\Models\Enums\TypeTuteurEnum::values() as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
                <label class="label-style">Téléphone du tuteur</label>
                <input type="text" name="telephone_tuteur" class="input-style" placeholder="+221 77...">
            </div>

            <!-- Responsable -->
            <div id="champs_responsable" class="hidden">
                <label class="label-style">Téléphone du responsable</label>
                <input type="text" name="telephone_responsable" class="input-style" placeholder="+221 77...">
            </div>

            <button type="submit" class="btn-primary mt-4">
                <i class="fas fa-check-circle me-2"></i> Valider l'inscription
            </button>
        </form>
    </div>

    <script>
        function afficherChampsSpecifiques() {
            const roleId = parseInt(document.getElementById('role_enum_id').value);
            const champsTuteur = document.getElementById('champs_tuteur');
            const champsResponsable = document.getElementById('champs_responsable');

            if (roleId === 1) {
                champsTuteur.classList.remove('hidden');
                champsResponsable.classList.add('hidden');
            } else if (roleId === 2) {
                champsResponsable.classList.remove('hidden');
                champsTuteur.classList.add('hidden');
            } else {
                champsTuteur.classList.add('hidden');
                champsResponsable.classList.add('hidden');
            }
        }

        window.addEventListener('DOMContentLoaded', afficherChampsSpecifiques);
    </script>
</body>

</html>
