<?php
// index.php
include 'includes/config.php';
include 'includes/header.php';
?>

<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center -mx-4">
                <div class="w-full lg:w-1/2 px-4 mb-16 lg:mb-0">
                    <span class="text-lg font-bold text-blue-500">Kotaybi - Listes partagées</span>
                    <h1 class="mt-6 mb-6 text-4xl md:text-5xl lg:text-6xl font-bold font-heading animate-fadeIn">
                        Gérez vos courses en famille ou entre amis
                    </h1>
                    <p class="mb-8 text-lg text-gray-500 leading-relaxed">
                        Créez, partagez et suivez vos listes de courses en temps réel. Plus jamais vous n'oublierez d'acheter ce dont vous avez besoin.
                    </p>
                    <div class="flex flex-wrap">
                        <a href="register.php" class="w-full md:w-auto px-8 py-4 mb-4 md:mb-0 md:mr-4 text-center text-white font-bold bg-blue-500 hover:bg-blue-600 rounded-full transition duration-200 transform hover:scale-105">
                            Commencer gratuitement
                        </a>
                        <a href="login.php" class="w-full md:w-auto px-8 py-4 text-center text-blue-500 font-bold bg-white hover:bg-gray-100 rounded-full transition duration-200">
                            Se connecter
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 px-4">
                    <div class="relative mx-auto max-w-max">
                        <img class="absolute z-10 -left-7 -top-7 w-28 h-28 animate-float" src="assets/images/shopping-bag.png" alt="">
                        <img class="absolute z-10 -right-7 -bottom-7 w-28 h-28 animate-float-delay" src="assets/images/shopping-cart.png" alt="">
                        <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                            <img class="w-full h-auto" src="assets/images/app-screenshot.png" alt="Capture d'écran de l'application">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto mb-20 text-center">
                <span class="text-lg font-bold text-blue-500">Pourquoi choisir Kotaybi?</span>
                <h2 class="mt-8 mb-10 text-3xl md:text-4xl font-bold font-heading">Une expérience de liste de courses révolutionnaire</h2>
            </div>
            <div class="flex flex-wrap -mx-4 -mb-16">
                <!-- Feature 1 -->
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-16 wow fadeInUp" data-wow-delay=".1s">
                    <div class="px-8 py-12 bg-gray-50 rounded-2xl text-center">
                        <div class="mb-6 inline-flex items-center justify-center w-16 h-16 bg-blue-500 rounded-full">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold font-heading">Partage facile</h3>
                        <p class="text-gray-500 leading-relaxed">Partagez vos listes avec votre famille ou vos colocataires en quelques clics.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-16 wow fadeInUp" data-wow-delay=".3s">
                    <div class="px-8 py-12 bg-gray-50 rounded-2xl text-center">
                        <div class="mb-6 inline-flex items-center justify-center w-16 h-16 bg-blue-500 rounded-full">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold font-heading">En temps réel</h3>
                        <p class="text-gray-500 leading-relaxed">Les modifications sont synchronisées instantanément pour tous les participants.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-16 wow fadeInUp" data-wow-delay=".5s">
                    <div class="px-8 py-12 bg-gray-50 rounded-2xl text-center">
                        <div class="mb-6 inline-flex items-center justify-center w-16 h-16 bg-blue-500 rounded-full">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold font-heading">Gratuit</h3>
                        <p class="text-gray-500 leading-relaxed">Notre service est entièrement gratuit, sans publicité ni limitations cachées.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>