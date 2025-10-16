<?php
// register.php

include 'includes/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }
    
    if (empty($email)) {
        $errors[] = "L'adresse email est requise";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Une adresse email valide est requise";
    }
    
    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    
    if (!isset($_POST['terms'])) {
        $errors[] = "Vous devez accepter les conditions d'utilisation";
    }
    
    // Vérifier si l'email existe déjà
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id_user FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $errors[] = "Cette adresse email est déjà utilisée";
        }
    }
    
    if (empty($errors)) {
        // Solution de secours pour anciennes versions de PHP
        if (!function_exists('password_hash')) {
            // Alternative sécurisée pour PHP < 5.5
            $salt = '$2y$10$' . md5(uniqid(mt_rand(), true)); // Solution alternative
            $hashed_password = crypt($password, $salt);
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password]);
            
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            
            header('Location: dashboard.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    }
}

include 'includes/header.php';
?>

<!-- Le reste de votre code HTML reste inchangé -->

<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl animate-fadeIn">
        <div>
            <img class="mx-auto h-12 w-auto" src="assets/images/logo.png" alt="Kotaybi">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créez votre compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Déjà membre? <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">Connectez-vous ici</a>
            </p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p class="mb-1"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form class="mt-8 space-y-6" action="register.php" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Nom complet</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Nom complet">
                </div>
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Adresse email">
                </div>
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Mot de passe (8 caractères minimum)">
                </div>
                <div>
                    <label for="confirm_password" class="sr-only">Confirmer le mot de passe</label>
                    <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Confirmer le mot de passe">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" <?= isset($_POST['terms']) ? 'checked' : '' ?> required 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    J'accepte les <a href="#" class="font-medium text-blue-600 hover:text-blue-500">conditions d'utilisation</a>
                </label>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-105">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    S'inscrire
                </button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>