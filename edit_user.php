<?php
// edit_user.php
session_start();
include 'includes/config.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Récupérer l'ID de l'utilisateur
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT nom, email, role FROM utilisateurs WHERE id_user = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: admin_dashboard.php?error=Utilisateur non trouvé');
    exit;
}

// Mettre à jour l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    if (empty($name) || empty($email) || empty($role)) {
        $error = "Tous les champs sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif (!in_array($role, ['admin', 'user'])) {
        $error = "Rôle invalide.";
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, email = ?, role = ? WHERE id_user = ?");
        $stmt->execute([$name, $email, $role, $user_id]);
        header('Location: admin_dashboard.php?success=Utilisateur mis à jour');
        exit;
    }
}
?>

<main class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50 py-10">
    <div class="container mx-auto px-4">
        <h1 class="mb-6 text-3xl font-bold text-blue-600 text-center">Modifier l'utilisateur</h1>

        <?php if (isset($error)): ?>
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg animate-fadeIn">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
            <form method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['nom']); ?>" class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                    <select name="role" id="role" class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition transform hover:scale-105">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>