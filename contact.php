<?php
// contact.php
include 'includes/config.php';
include 'includes/header.php';

// Initialiser les variables
$error = $success = '';
$data = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];

// Vérifier si une session est démarrée
if (session_id() === '') {
    session_start();
}

// Générer un token CSRF
$_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de validation CSRF.";
    } else {
        // Récupérer et nettoyer les données
        $data['first_name'] = trim($_POST['first-name']);
        $data['last_name'] = trim($_POST['last-name']);
        $data['email'] = trim($_POST['email']);
        $data['subject'] = trim($_POST['subject']);
        $data['message'] = trim($_POST['message']);

        // Validation des champs requis
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
            $error = "Tous les champs sont requis.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error = "Email invalide.";
        } else {
            try {
                // Insérer les données dans la base de données
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $name = $data['first_name'] . ' ' . $data['last_name'];
                $stmt->execute([$name, $data['email'], $data['subject'], $data['message']]);
                $success = "Message envoyé avec succès !";
                $data = array_fill_keys(array_keys($data), ''); // Réinitialiser les champs après succès
            } catch (PDOException $e) {
                $error = "Erreur lors de l'envoi du message : " . $e->getMessage();
            }
        }
    }
}
?>

<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 animate-fadeIn">Contactez-nous</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Vous avez des questions ou des suggestions ? Notre équipe est là pour vous aider.
            </p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>

                <form method="POST" action="" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                            <input type="text" id="first-name" name="first-name" value="<?= htmlspecialchars($data['first_name'], ENT_QUOTES, 'UTF-8') ?>" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <input type="text" id="last-name" name="last-name" value="<?= htmlspecialchars($data['last_name'], ENT_QUOTES, 'UTF-8') ?>" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8') ?>" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                        <select id="subject" name="subject" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="" disabled <?= !$data['subject'] ? 'selected' : '' ?>>Sélectionnez un sujet</option>
                            <option value="support" <?= $data['subject'] === 'support' ? 'selected' : '' ?>>Support technique</option>
                            <option value="feedback" <?= $data['subject'] === 'feedback' ? 'selected' : '' ?>>Retour d'expérience</option>
                            <option value="partnership" <?= $data['subject'] === 'partnership' ? 'selected' : '' ?>>Partenariat</option>
                            <option value="other" <?= $data['subject'] === 'other' ? 'selected' : '' ?>>Autre</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="5" required 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"><?= htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="consent" name="consent" required 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="consent" class="ml-2 block text-sm text-gray-700">
                            J'accepte que mes informations soient utilisées pour répondre à ma demande.
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 transform hover:scale-[1.02]">
                        Envoyer le message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Nos coordonnées</h2>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Téléphone</h3>
                                <p class="mt-1 text-gray-600">+33 1 23 45 67 89</p>
                                <p class="mt-1 text-gray-600">Lundi - Vendredi, 9h - 18h</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                                <p class="mt-1 text-gray-600">contact@kadhyetna.com</p>
                                <p class="mt-1 text-gray-600">Support: support@kotaybi.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Adresse</h3>
                                <p class="mt-1 text-gray-600">123 Rue des Listes</p>
                                <p class="mt-1 text-gray-600">75001 Paris, France</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Link -->
                <div class="bg-blue-600 rounded-2xl shadow-xl p-8 text-white">
                    <h2 class="text-2xl font-bold mb-4">Questions fréquentes</h2>
                    <p class="mb-6">Vous trouverez peut-être la réponse à votre question dans notre centre d'aide.</p>
                    <a href="#" class="inline-flex items-center font-medium text-white hover:text-blue-100 transition duration-200">
                        Consulter la FAQ
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>