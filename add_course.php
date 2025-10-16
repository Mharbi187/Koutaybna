<?php
// add_course.php
session_start();
include 'includes/config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les catégories pour le filtre
$stmt = $pdo->query("SELECT DISTINCT categorie FROM produits WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie ASC");
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les produits avec filtrage
$category_filter = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT id_produit, nom, categorie FROM produits WHERE 1=1";
$params = [];

if (!empty($category_filter)) {
    $sql .= " AND categorie = ?";
    $params[] = $category_filter;
}

if (!empty($search_query)) {
    $sql .= " AND nom LIKE ?";
    $params[] = "%$search_query%";
}

$sql .= " ORDER BY categorie ASC, nom ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Regrouper par catégorie
$products_by_category = [];
foreach ($products as $product) {
    $cat = $product['categorie'] ? $product['categorie'] : 'Non catégorisé';
    $products_by_category[$cat][] = $product;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_list'])) {
    $nom_liste = trim($_POST['nom_liste']);
    $cours = isset($_POST['cours']) ? trim($_POST['cours']) : null;
    $selected_products = isset($_POST['products']) ? $_POST['products'] : [];
    
    if (empty($nom_liste)) {
        $error = "Le nom de la liste est requis.";
    } elseif (empty($selected_products)) {
        $error = "Sélectionnez au moins un produit.";
    } else {
        try {
            $pdo->beginTransaction();
            
            // Créer la liste
            $stmt = $pdo->prepare("INSERT INTO listes (nom_liste, id_createur, date_creation, date_modification, cours) VALUES (?, ?, NOW(), NOW(), ?)");
            $stmt->execute([$nom_liste, $_SESSION['user_id'], $cours]);
            $liste_id = $pdo->lastInsertId();
            
            // Ajouter les produits
            foreach ($selected_products as $product_id) {
                $quantity = isset($_POST['quantity_'.$product_id]) && $_POST['quantity_'.$product_id] > 0 ? (int)$_POST['quantity_'.$product_id] : 1;
                $stmt = $pdo->prepare("INSERT INTO liste_produit (id_liste, id_produit, quantite, coche, date_ajout) VALUES (?, ?, ?, 0, NOW())");
                $stmt->execute([$liste_id, $product_id, $quantity]);
            }
            
            $pdo->commit();
            header('Location: view_lists.php?success=Liste créée avec succès');
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la création : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une liste - Kotaybi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<?php include 'includes/header.php'; ?>

<main class="min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-blue-800 mb-6 text-center">Créer une nouvelle liste</h1>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <form method="POST" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="nom_liste" class="block text-sm font-medium text-gray-700 mb-1">Nom de la liste </label>
                            <input type="text" id="nom_liste" name="nom_liste" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                    </div>
                    
                    <!-- Filtres -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-medium text-lg text-gray-800 mb-3">Filtrer les produits</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                                <select id="categorie" name="categorie" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                        onchange="this.form.submit()">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category_filter === $cat ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                                <div class="flex">
                                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_query); ?>"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500">
                                    <button type="submit" class="px-4 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Liste des produits -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Sélectionnez vos produits</h3>
                        
                        <?php if (empty($products_by_category)): ?>
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">Aucun produit trouvé. Essayez de modifier vos filtres.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                                <?php foreach ($products_by_category as $category => $cat_products): ?>
                                    <div class="border-b pb-4 last:border-b-0">
                                        <h4 class="font-medium text-blue-700 mb-3"><?php echo htmlspecialchars($category); ?></h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <?php foreach ($cat_products as $product): ?>
                                                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                                                    <input type="checkbox" name="products[]" value="<?php echo $product['id_produit']; ?>" 
                                                           id="product_<?php echo $product['id_produit']; ?>"
                                                           class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 mr-3">
                                                    <label for="product_<?php echo $product['id_produit']; ?>" class="flex-1 cursor-pointer">
                                                        <?php echo htmlspecialchars($product['nom']); ?>
                                                    </label>
                                                    <input type="number" name="quantity_<?php echo $product['id_produit']; ?>" 
                                                           min="1" value="1" 
                                                           class="w-16 px-2 py-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex justify-between pt-4 border-t">
                        <a href="view_lists.php" class="px-6 py-2 text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </a>
                        <button type="submit" name="create_list" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Créer la liste
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html> 