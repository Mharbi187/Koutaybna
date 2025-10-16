<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les produits, triés par catégorie et date d'ajout
$stmt = $pdo->query("
    SELECT p.id_produit, p.nom, p.categorie, p.`photo-prod`
    FROM produits p
    ORDER BY p.categorie ASC, p.id_produit DESC
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nombre de listes de l'utilisateur
$stmt = $pdo->prepare("SELECT COUNT(*) FROM listes WHERE id_createur = ?");
$stmt->execute([$_SESSION['user_id']]);
$list_count = $stmt->fetchColumn();

// Regrouper les produits par catégorie
$products_by_category = array();
foreach ($products as $product) {
    $category = !empty($product['categorie']) ? $product['categorie'] : 'Non catégorisé';
    $products_by_category[$category][] = $product;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Kotaybi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<?php include 'includes/header.php'; ?>

<main class="min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="text-center mb-12 bg-white p-8 rounded-xl shadow-lg">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-800 mb-4">
                Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8'); ?> !
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Gérez vos listes de courses et découvrez nos produits.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="add_course.php" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Nouvelle liste
                </a>
                <a href="view_lists.php" class="px-6 py-3 bg-white text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition flex items-center">
                    <i class="fas fa-list-ul mr-2"></i> Mes listes (<?php echo $list_count; ?>)
                </a>
                <a href="edit_profile.php" class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <i class="fas fa-user-edit mr-2"></i> Profil
                </a>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Listes actives</h3>
                <p class="text-3xl font-bold text-blue-600"><?php echo $list_count; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Produits disponibles</h3>
                <p class="text-3xl font-bold text-green-600"><?php echo count($products); ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Catégories</h3>
                <p class="text-3xl font-bold text-purple-600"><?php echo count($products_by_category); ?></p>
            </div>
        </div>

        <!-- Section Produits -->
        <section class="mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Nos produits</h2>
                <div class="relative">
                    <input type="text" placeholder="Rechercher un produit..." class="pl-10 pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <?php if (empty($products_by_category)): ?>
                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <p class="text-gray-500 mb-4">Aucun produit disponible pour le moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($products_by_category as $category => $products): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-blue-700 mb-4 flex items-center">
                            <i class="fas fa-tag mr-2 text-blue-500"></i>
                            <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <?php foreach ($products as $product): ?>
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                                    <div class="h-40 bg-gray-100 flex items-center justify-center">
                                        <?php if (!empty($product['photo-prod'])): ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['photo-prod']); ?>" 
                                                 alt="<?php echo htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                 class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <i class="fas fa-image text-gray-300 text-4xl"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-800 mb-2 truncate"><?php echo htmlspecialchars($product['nom'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">#<?php echo $product['id_produit']; ?></span>
                                            <button class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>