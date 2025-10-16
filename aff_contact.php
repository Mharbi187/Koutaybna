<?php
// Vérifier si une session est déjà démarrée (compatible PHP 5.3)
if (!isset($_SESSION)) {
    session_start();
}

// Inclure la configuration de la base de données
require_once 'includes/config.php';

// Assurer l'encodage UTF-8 pour la connexion
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('SET NAMES utf8'); // Utiliser utf8 au lieu de utf8mb4 pour compatibilité

// Traitement de l'envoi de formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            if ($stmt->execute(array($name, $email, $message))) {
                $success = "Message envoyé avec succès !";
            } else {
                $error = "Erreur lors de l'envoi du message.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de base de données : " . $e->getMessage();
        }
    }
}

// Traitement de la suppression (avec protection CSRF)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message']) && isset($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $id = (int)$_POST['delete_message'];
        try {
            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
            if ($stmt->execute(array($id))) {
                $_SESSION['success'] = "Message supprimé avec succès";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Erreur lors de la suppression du message.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de base de données : " . $e->getMessage();
        }
    } else {
        $error = "Erreur de validation CSRF.";
    }
}

// Générer un token CSRF (compatible PHP 5.x)
$_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));

// Récupération des messages avec pagination et tri
$sort = isset($_GET['sort']) && in_array($_GET['sort'], array('asc', 'desc')) ? $_GET['sort'] : 'desc';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$messages = array();
$totalMessages = 0;
$totalPages = 0;

try {
    // Vérifier si la table existe
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'contact'");
    if ($tableCheck->rowCount() > 0) {
        // Récupérer les messages
        $stmt = $pdo->prepare("SELECT * FROM contact_messages ORDER BY created_at " . ($sort === 'asc' ? 'ASC' : 'DESC') . " LIMIT ? OFFSET ?");
        $stmt->bindValue(1, (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Compter le nombre total de messages
        $totalStmt = $pdo->query("SELECT COUNT(*) FROM contact_messages");
        $totalMessages = $totalStmt->fetchColumn();
        $totalPages = ceil($totalMessages / $perPage);
    } else {
        $error = "La table 'contact' n'existe pas dans la base de données.";
    }
} catch (PDOException $e) {
    $error = "Erreur de base de données : " . $e->getMessage();
}
?>

<!-- Section Messages de Contact -->
<section class="mb-16">
    <h2 class="mb-6 text-3xl font-bold text-gray-800">Messages de contact</h2>

    <!-- Options de tri -->
    <div class="mb-4 flex justify-end">
        <a href="?sort=desc" class="px-3 py-2 <?php echo $sort === 'desc' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded-lg mr-2">Plus récent</a>
        <a href="?sort=asc" class="px-3 py-2 <?php echo $sort === 'asc' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded-lg">Plus ancien</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded"><?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="w-full text-left">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Nom</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Message</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="p-4"><?php echo htmlspecialchars($message['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4"><?php echo htmlspecialchars($message['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4"><?php echo htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="p-4" title="<?php echo htmlspecialchars($message['message'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(substr($message['message'], 0, 50), ENT_QUOTES, 'UTF-8'); ?>
                                <?php echo strlen($message['message']) > 50 ? '...' : ''; ?>
                            </td>
                            <td class="p-4"><?php echo date('d/m/Y H:i', strtotime($message['created_at'])); ?></td>
                            <td class="p-4">
                                <form method="POST" action="" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                                    <input type="hidden" name="delete_message" value="<?php echo $message['id']; ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <button type="submit" class="inline-block px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition transform hover:scale-105">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Aucun message trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="mt-4 flex justify-center space-x-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="px-3 py-1 rounded-lg <?php echo $i === $page ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> transition">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</section>