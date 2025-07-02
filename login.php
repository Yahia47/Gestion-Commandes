<?php
session_start();
include_once("main.php");

$msg = "";
$msg_type = "";

// Traitement de l'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "register") {
    if (!empty($_POST["username_register"]) && !empty($_POST["email_register"]) && !empty($_POST["password_register"]) && !empty($_POST["confirm_password_register"])) {

        if ($_POST["password_register"] != $_POST["confirm_password_register"]) {
            $msg = "Les mots de passe ne correspondent pas.";
            $msg_type = "danger";
        } else {
            // Vérifier si l'email existe déjà
            $check_query = "SELECT COUNT(*) FROM user WHERE email = :email";
            $check_stmt = $pdo->prepare($check_query);
            $check_stmt->execute(['email' => $_POST["email_register"]]);

            if ($check_stmt->fetchColumn() > 0) {
                $msg = "Cette adresse email est déjà utilisée.";
                $msg_type = "danger";
            } else {
                // Vérifier si le username existe déjà
                $check_username_query = "SELECT COUNT(*) FROM user WHERE username = :username";
                $check_username_stmt = $pdo->prepare($check_username_query);
                $check_username_stmt->execute(['username' => $_POST["username_register"]]);

                if ($check_username_stmt->fetchColumn() > 0) {
                    $msg = "Ce nom d'utilisateur est déjà pris.";
                    $msg_type = "danger";
                } else {
                    try {
                        $query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
                        $pdostmt = $pdo->prepare($query);
                        $result = $pdostmt->execute([
                            "username" => $_POST["username_register"],
                            "email" => $_POST["email_register"],
                            "password" => password_hash($_POST["password_register"], PASSWORD_DEFAULT),
                        ]);

                        if ($result) {
                            $msg = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                            $msg_type = "success";
                        } else {
                            $msg = "Erreur lors de l'inscription.";
                            $msg_type = "danger";
                        }
                    } catch (Exception $e) {
                        $msg = "Erreur : " . $e->getMessage();
                        $msg_type = "danger";
                    }
                }
            }
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
        $msg_type = "danger";
    }
}

// Traitement de la connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "login") {
    if (!empty($_POST["email_login"]) && !empty($_POST["password_login"])) {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $pdostmt = $pdo->prepare($query);
            $pdostmt->execute(['email' => $_POST["email_login"]]);
            $user = $pdostmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($_POST["password_login"], $user['password'])) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                $msg = "Connexion réussie ! Redirection en cours...";
                $msg_type = "success";

                // Redirection après 2 secondes
                header("refresh:2;url=index.php");
            } else {
                $msg = "Email ou mot de passe incorrect.";
                $msg_type = "danger";
            }
        } catch (Exception $e) {
            $msg = "Erreur de connexion : " . $e->getMessage();
            $msg_type = "danger";
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
        $msg_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion et inscription">
    <title>Connexion & Inscription</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #f8fafc;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
            --success-color: #10b981;
            --error-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        .auth-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .auth-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 2.5rem;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating>.form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-floating>.form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
            background-color: white;
        }

        .form-floating>label {
            color: #6b7280;
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .toggle-buttons {
            display: flex;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 0.25rem;
            margin-bottom: 2rem;
        }

        .toggle-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #64748b;
        }

        .toggle-btn.active {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #6b7280;
            font-weight: 500;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: white;
            color: #374151;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: inline-block;
        }

        .strength-meter {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: var(--error-color);
        }

        .strength-medium {
            background: var(--warning-color);
        }

        .strength-strong {
            background: var(--success-color);
        }

        @media (max-width: 768px) {
            .auth-card {
                margin: 10px;
                border-radius: 15px;
            }

            .auth-header {
                padding: 1.5rem;
            }

            .auth-header h1 {
                font-size: 2rem;
            }

            .auth-body {
                padding: 1.5rem;
            }

            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>

<body class="h-100">
    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <h1><i class="bi bi-shield-lock"></i> Authentification</h1>
                <p>Accédez à votre espace personnel en toute sécurité</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Toggle Buttons -->
                <div class="toggle-buttons">
                    <button type="button" class="toggle-btn active" id="loginToggle">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                    </button>
                    <button type="button" class="toggle-btn" id="registerToggle">
                        <i class="bi bi-person-plus me-2"></i>Inscription
                    </button>
                </div>

                <!-- Alerts PHP -->
                <?php if (!empty($msg)): ?>
                    <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                        <i class="bi <?php echo $msg_type == 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'; ?> me-2"></i>
                        <?php echo htmlspecialchars($msg); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Alerts JS -->
                <div id="alertContainer"></div>

                <!-- Login Form -->
                <div class="form-container active" id="loginForm">
                    <form method="POST" action="" novalidate>
                        <input type="hidden" name="action" value="login">

                        <div class="form-floating">
                            <input type="email" class="form-control" name="email_login" id="loginEmail" placeholder="nom@exemple.com" required>
                            <label for="loginEmail"><i class="bi bi-envelope me-2"></i>Adresse email</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating position-relative">
                            <input type="password" class="form-control" name="password_login" id="loginPassword" placeholder="Mot de passe" required>
                            <label for="loginPassword"><i class="bi bi-lock me-2"></i>Mot de passe</label>
                            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">
                                <i class="bi bi-eye" id="loginPasswordIcon"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Se souvenir de moi
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none" style="color: var(--primary-color);">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </form>


                </div>

                <!-- Register Form -->
                <div class="form-container" id="registerForm">
                    <form method="POST" action="" novalidate>
                        <input type="hidden" name="action" value="register">

                        <div class="form-floating">
                            <input type="text" class="form-control" name="username_register" id="username" placeholder="username" required>
                            <label for="username"><i class="bi bi-person me-2"></i>Nom d'utilisateur</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating">
                            <input type="email" class="form-control" name="email_register" id="registerEmail" placeholder="nom@exemple.com" required>
                            <label for="registerEmail"><i class="bi bi-envelope me-2"></i>Adresse email</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-floating position-relative">
                            <input type="password" class="form-control" name="password_register" id="registerPassword" placeholder="Mot de passe" required>
                            <label for="registerPassword"><i class="bi bi-lock me-2"></i>Mot de passe</label>
                            <button type="button" class="password-toggle" onclick="togglePassword('registerPassword')">
                                <i class="bi bi-eye" id="registerPasswordIcon"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                            <div class="strength-meter">
                                <div class="strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted" id="strengthText">Saisissez un mot de passe</small>
                        </div>

                        <div class="form-floating position-relative">
                            <input type="password" class="form-control" name="confirm_password_register" id="confirmPassword" placeholder="Confirmer le mot de passe" required>
                            <label for="confirmPassword"><i class="bi bi-lock me-2"></i>Confirmer le mot de passe</label>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>



                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-person-plus me-2"></i>Créer mon compte
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Toggle between login and register forms
        document.getElementById('loginToggle').addEventListener('click', function() {
            showForm('login');
        });

        document.getElementById('registerToggle').addEventListener('click', function() {
            showForm('register');
        });

        function showForm(formType) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginToggle = document.getElementById('loginToggle');
            const registerToggle = document.getElementById('registerToggle');

            if (formType === 'login') {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                loginToggle.classList.add('active');
                registerToggle.classList.remove('active');
            } else {
                registerForm.classList.add('active');
                loginForm.classList.remove('active');
                registerToggle.classList.add('active');
                loginToggle.classList.remove('active');
            }

            // Clear alerts
            document.getElementById('alertContainer').innerHTML = '';
        }

        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Password strength checker
        document.getElementById('registerPassword').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');

            const strength = calculatePasswordStrength(password);

            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = 'strength-bar ' + strength.class;
            strengthText.textContent = strength.text;
            strengthText.style.color = getStrengthColor(strength.class);
        });

        function calculatePasswordStrength(password) {
            let score = 0;

            if (password.length >= 8) score += 25;
            if (password.match(/[a-z]/)) score += 25;
            if (password.match(/[A-Z]/)) score += 25;
            if (password.match(/[0-9]/)) score += 15;
            if (password.match(/[^a-zA-Z0-9]/)) score += 10;

            if (score < 50) {
                return {
                    percentage: score,
                    class: 'strength-weak',
                    text: 'Mot de passe faible'
                };
            } else if (score < 80) {
                return {
                    percentage: score,
                    class: 'strength-medium',
                    text: 'Mot de passe moyen'
                };
            } else {
                return {
                    percentage: score,
                    class: 'strength-strong',
                    text: 'Mot de passe fort'
                };
            }
        }

        function getStrengthColor(strengthClass) {
            switch (strengthClass) {
                case 'strength-weak':
                    return '#ef4444';
                case 'strength-medium':
                    return '#f59e0b';
                case 'strength-strong':
                    return '#10b981';
                default:
                    return '#6b7280';
            }
        }

        // Form validation
        function validateForm(form) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required]');

            inputs.forEach(input => {
                const feedback = input.nextElementSibling?.nextElementSibling || input.parentNode.querySelector('.invalid-feedback');

                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    if (feedback) feedback.textContent = 'Ce champ est requis.';
                    isValid = false;
                } else if (input.type === 'email' && !isValidEmail(input.value)) {
                    input.classList.add('is-invalid');
                    if (feedback) feedback.textContent = 'Veuillez saisir une adresse email valide.';
                    isValid = false;
                } else if (input.id === 'confirmPassword' && input.value !== document.getElementById('registerPassword').value) {
                    input.classList.add('is-invalid');
                    if (feedback) feedback.textContent = 'Les mots de passe ne correspondent pas.';
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });

            return isValid;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Clear validation on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid', 'is-valid');
            });
        });

        // Show alert
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';

            alertContainer.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="bi ${icon} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        // Social login handlers
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const provider = this.textContent.trim();
                showAlert(`Connexion avec ${provider} en cours...`, 'success');
            });
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('show')) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                    }
                });
            }, 5000);
        });
    </script>
</body>

</html>