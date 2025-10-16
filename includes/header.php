<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// includes/header.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kadhyetna - Gestion de listes de courses partagées</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
</head>
<body class="font-sans antialiased text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="<?php echo isset($_SESSION['user_id']) ? 'user_dashboard.php' : 'index.php'; ?>" class="flex items-center">
                    <img src="assets/images/logo.png" alt="Kotaybi" class="h-8">
                    <span class="ml-2 text-xl font-bold text-blue-600">Kadhyetna</span>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Logged in navigation -->
                        <a href="user_dashboard.php" class="<?= $current_page === 'user_dashboard.php' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' ?> transition duration-200">Accueil</a>
                        <a href="add_course.php" class="<?= $current_page === 'add_course.php' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' ?> transition duration-200">Nouvelle liste</a>
                        <a href="view_lists.php" class="<?= $current_page === 'view_lists.php' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' ?> transition duration-200">Mes listes</a>
                        <a href="products.php" class="<?= $current_page === 'products.php' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' ?> transition duration-200">Produits</a>
                        
                        <div class="flex items-center space-x-4 ml-6">
                            <a href="logout.php" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Guest navigation -->
                        <a href="index.php" class="<?= $current_page === 'index.php' ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' ?> transition duration-200">Accueil</a>
                        <a href="Fonctionnalites.php" class="text-gray-600 hover:text-blue-600 transition duration-200">Fonctionnalités</a>
                        <a href="contact.php" class="text-gray-600 hover:text-blue-600 transition duration-200">Contact</a>
                        
                        <div class="flex items-center space-x-4 ml-6">
                            <a href="login.php" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200">Connexion</a>
                            <a href="register.php" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition duration-200 transform hover:scale-105">Inscription</a>
                        </div>
                    <?php endif; ?>
                </nav>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged in mobile navigation -->
                    <a href="user_dashboard.php" class="block px-3 py-2 rounded-md <?= $current_page === 'user_dashboard.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50' ?>">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>
                    <a href="add_course.php" class="block px-3 py-2 rounded-md <?= $current_page === 'add_course.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50' ?>">
                        <i class="fas fa-plus-circle mr-2"></i> Nouvelle liste
                    </a>
                    <a href="view_lists.php" class="block px-3 py-2 rounded-md <?= $current_page === 'view_lists.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50' ?>">
                        <i class="fas fa-list-ul mr-2"></i> Mes listes
                    </a>
                    <a href="products.php" class="block px-3 py-2 rounded-md <?= $current_page === 'products.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50' ?>">
                        <i class="fas fa-shopping-bag mr-2"></i> Produits
                    </a>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="logout.php" class="block px-3 py-2 rounded-md text-red-600 hover:bg-red-50 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Guest mobile navigation -->
                    <a href="index.php" class="block px-3 py-2 rounded-md <?= $current_page === 'index.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50' ?>">Accueil</a>
                    <a href="Fonctionnalités.php" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-blue-50">Fonctionnalités</a>
                    <a href="contact.php" class="block px-3 py-2 rounded-md text-gray-600 hover:bg-blue-50">Contact</a>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="login.php" class="block px-3 py-2 rounded-md text-blue-600 hover:bg-blue-50">Connexion</a>
                        <a href="register.php" class="block px-3 py-2 mt-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Inscription</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>