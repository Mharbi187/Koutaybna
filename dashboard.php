<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Récupérer les utilisateurs
$stmt = $pdo->query("SELECT id_user, nom, email FROM utilisateurs ORDER BY id_user DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les messages de contact
$stmt = $pdo->query("SELECT id, name, email, message, created_at FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un utilisateur
if (isset($_GET['delete_user'])) {
    $user_id = (int)$_GET['delete_user'];
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id_user = ?");
    $stmt->execute([$user_id]);
    header('Location: admin_dashboard.php?success=Utilisateur supprimé');
    exit;
}

// Supprimer un message
if (isset($_GET['delete_message'])) {
    $message_id = (int)$_GET['delete_message'];
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$message_id]);
    header('Location: admin_dashboard.php?success=Message supprimé');
    exit;
}
?>

<main class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50 py-10">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-600 animate-fadeIn">
                Tableau de bord administrateur
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Gérez les utilisateurs et les messages de contact de Kadhyetna
            </p>
        </div>

        <!-- Messages de succès -->
        <?php if (isset($_GET['success'])): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg animate-fadeIn">
                <?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Section Utilisateurs -->
        <section class="mb-16">
            <h2 class="mb-6 text-3xl font-bold text-gray-800">Gestion des utilisateurs</h2>
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="w-full text-left">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="p-4">Nom</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b hover:bg-gray-50 transition duration-200">
                                <td class="p-4"><?php echo htmlspecialchars($user['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-4"><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="p-4">
                                    <a href="edit_user.php?id=<?php echo $user['id_user']; ?>" class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition transform hover:scale-105">Modifier</a>
                                    <a href="admin_dashboard.php?delete_user=<?php echo $user['id_user']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" class="inline-block px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition transform hover:scale-105">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

      <!-- Section Messages de Contact -->
      <?php include 'aff_contact.php'; ?>

        <!-- Section Recommandations Animées -->
        <section class="mb-16">
            <h2 class="mb-6 text-3xl font-bold text-gray-800">Recommandations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-xl shadow-lg transform transition duration-500 hover:scale-105 wow fadeInUp" data-wow-delay=".1s">
                    <h3 class="mb-3 text-xl font-bold text-blue-600">Vérification utilisateur</h3>
                    <p class="text-gray-600">
                        Envoyez des rappels automatiques aux utilisateurs pour vérifier leur email.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg transform transition duration-500 hover:scale-105 wow fadeInUp" data-wow-delay=".2s">
                    <h3 class="mb-3 text-xl font-bold text-blue-600">Analyse des messages</h3>
                    <p class="text-gray-600">
                        Identifiez les questions fréquentes dans les messages pour créer une FAQ dynamique.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg transform transition duration-500 hover:scale-105 wow fadeInUp" data-wow-delay=".3s">
                    <h3 class="mb-3 text-xl font-bold text-blue-600">Engagement utilisateur</h3>
                    <p class="text-gray-600">
                        Ajoutez des notifications push pour informer les utilisateurs des mises à jour.
                    </p>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>