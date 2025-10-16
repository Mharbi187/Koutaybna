<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['user', 'admin'])) {
        // Rôle invalide, déconnexion
        session_destroy();
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
        header('Location: login.php');
        exit;
    }
    $redirect = $_SESSION['role'] === 'admin' ? 'dashboard.php' : 'user_dashboard.php';
    header('Location: ' . $redirect);
    exit;
}

// Vérifier le jeton "Se souvenir de moi"
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    $stmt = $pdo->prepare("SELECT id_user, nom, role FROM utilisateurs WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && in_array($user['role'], ['user', 'admin'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['role'] = $user['role'];
        $redirect = $user['role'] === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php';
        header('Location: ' . $redirect);
        exit;
    } else {
        // Supprimer le cookie invalide
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $remember = isset($_POST['remember-me']);

    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT id_user, nom, email, mot_de_passe, role FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $passwordValid = false;
        if ($user) {
            // PHP 5.2/5.3 lacks password_verify, use crypt() comparison
            $hashed_password = crypt($password, $user['mot_de_passe']);
            $passwordValid = $hashed_password === $user['mot_de_passe'];
        }

        if ($user && $passwordValid && in_array($user['role'], ['user', 'admin'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['role'] = $user['role'];

            if ($remember) {
                // Generate token for PHP 5.2/5.3
                $token = md5(uniqid(mt_rand(), true));
                $stmt = $pdo->prepare("UPDATE utilisateurs SET remember_token = ? WHERE id_user = ?");
                $stmt->execute([$token, $user['id_user']]);
                setcookie('remember_me', $token, time() + (30 * 24 * 3600), '/', '', true, true);
            }

            $redirect = $user['role'] === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php';
            header('Location: ' . $redirect);
            exit;
        } else {
            $error = "Email, mot de passe ou rôle incorrect.";
        }
    }
}

include 'includes/header.php';
?>

<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl animate-fadeIn">
        <div>
            <img class="mx-auto h-12 w-auto" src="assets/images/logo.png" alt="Kotaybi" onerror="this.style.display='none'">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Connectez-vous à votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou <a href="register.php" class="font-medium text-blue-600 hover:text-blue-500">créez un compte gratuitement</a>
            </p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate-fadeIn" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="login.php" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Adresse email">
                </div>
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Mot de passe">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" 
                           <?php echo isset($_POST['remember-me']) ? 'checked' : ''; ?>
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
                </div>

                <div class="text-sm">
                    <a href="forgot_password.php" class="font-medium text-blue-600 hover:text-blue-500">Mot de passe oublié ?</a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-105">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Se connecter
                </button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>