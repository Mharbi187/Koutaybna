<?php
// includes/footer.php
?>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-1/4 px-4 mb-8">
                    <a href="index.php" class="flex items-center mb-6">
                        <img src="assets/images/logo-white.png" alt="Kotaybi" class="h-8">
                        <span class="ml-2 text-xl font-bold">Kotaybi</span>
                    </a>
                    <p class="text-gray-400 mb-6">La solution simple et efficace pour gérer vos listes de courses en famille ou entre amis.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition duration-200">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Fonctionnalités</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Tarifs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Blog</a></li>
                    </ul>
                </div>
                
                <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Cookies</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Mentions légales</a></li>
                    </ul>
                </div>
                
                <div class="w-full lg:w-1/4 px-4 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">Abonnez-vous pour recevoir nos dernières actualités et offres.</p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" class="px-4 py-2 w-full rounded-l-md focus:outline-none text-gray-900">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r-md transition duration-200">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 mt-8 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> Kotaybi. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>