<?php
// edit_profile.php
session_start();
include 'includes/config.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT nom, email FROM utilisateurs WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Mettre à jour le profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email)) {
        $error = "Le nom et l'email sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $stmt = $pdo->prepare("SELECT id_user FROM utilisateurs WHERE email = ? AND id_user != ?");
        $stmt->execute([$email, $_SESSION['user_id']]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Mettre à jour les informations
            $update_query = "UPDATE utilisateurs SET nom = ?, email = ?";
            $params = [$name, $email];

            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_query .= ", mot_de_passe = ?";
                $params[] = $hashed_password;
            }

            $update_query .= " WHERE id_user = ?";
            $params[] = $_SESSION['user_id'];

            $stmt = $pdo->prepare($update_query);
            $stmt->execute($params);

            // Mettre à jour la session
            $_SESSION['user_name'] = $name;
            header('Location: user_dashboard.php?success=Profil mis à jour');
            exit;
        }
    }
}
?>

<main class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50 py-10">
    <div class="container mx-auto px-4">
        <h1 class="mb-6 text-3xl font-bold text-blue-600 text-center animate-fadeIn">Modifier votre profil</h1>

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
                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe (facultatif)</label>
                    <input type="password" name="password" id="password" class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Laissez vide pour ne pas changer">
                </div>
                <div class="text-center">
                    <button type="submit" class="px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition transform hover:scale-105">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>