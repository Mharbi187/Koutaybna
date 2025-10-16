<?php
// view_lists.php
session_start();
include 'includes/config.php';
include 'includes/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Traitement suppression liste
if (isset($_POST['delete_list']) && isset($_POST['list_id'])) {
    $list_id = (int)$_POST['list_id'];
    
    // Vérifier que l'utilisateur est bien le propriétaire de la liste
    $check = $pdo->prepare("SELECT id_createur FROM listes WHERE id_liste = ?");
    $check->execute([$list_id]);
    $list_owner = $check->fetchColumn();
    
    if ($list_owner == $_SESSION['user_id']) {
        try {
            $pdo->beginTransaction();
            
            // Supprimer d'abord les associations liste-produit
            $stmt = $pdo->prepare("DELETE FROM liste_produit WHERE id_liste = ?");
            $stmt->execute([$list_id]);
            
            // Supprimer les partages associés à cette liste
            $stmt = $pdo->prepare("DELETE FROM liste_partagee WHERE id_liste = ?");
            $stmt->execute([$list_id]);
            
            // Puis supprimer la liste
            $stmt = $pdo->prepare("DELETE FROM listes WHERE id_liste = ?");
            $stmt->execute([$list_id]);
            
            $pdo->commit();
            $success_message = "Liste supprimée avec succès";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        $error_message = "Vous n'êtes pas autorisé à supprimer cette liste";
    }
}

// Récupérer les listes créées par l'utilisateur
$stmt = $pdo->prepare("
    SELECT l.*, 
           (SELECT COUNT(*) FROM liste_produit WHERE id_liste = l.id_liste) as nb_produits
    FROM listes l
    WHERE id_createur = ?
    ORDER BY date_creation DESC
");
$stmt->execute([$_SESSION['user_id']]);
$own_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer également les listes partagées avec l'utilisateur
$stmt = $pdo->prepare("
    SELECT l.*, 
           u.nom as createur_nom,
           lp.role,
           (SELECT COUNT(*) FROM liste_produit WHERE id_liste = l.id_liste) as nb_produits
    FROM listes l
    JOIN liste_partagee lp ON l.id_liste = lp.id_liste
    JOIN utilisateurs u ON l.id_createur = u.id_user
    WHERE lp.id_user = ?
    ORDER BY lp.date_partage DESC
");
$stmt->execute([$_SESSION['user_id']]);
$shared_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Messages flash
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes listes de courses - Kotaybi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

<main class="min-h-screen bg-gradient-to-b from-blue-50 to-indigo-50 py-10">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-600">Mes listes de courses</h1>
            <a href="add_course.php" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle liste
            </a>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <!-- Mes listes -->
        <section class="mb-10">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mes listes</h2>
            
            <?php if (empty($own_lists)): ?>
                <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore créé de liste de courses.</p>
                    <a href="add_course.php" class="inline-block px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Créer ma première liste</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($own_lists as $list): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-blue-600 mb-2"><?php echo htmlspecialchars($list['nom_liste']); ?></h3>
                                
                                <?php if (!empty($list['cours'])): ?>
                                    <p class="text-gray-600 mb-4">
                                        <span class="font-medium">Cours:</span> <?php echo htmlspecialchars($list['cours']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <p class="text-sm text-gray-500">
                                    Créée le <?php echo date('d/m/Y à H:i', strtotime($list['date_creation'])); ?>
                                </p>
                                
                                <div class="mt-4 text-sm text-gray-600">
                                    <span class="font-medium"><?php echo $list['nb_produits']; ?> produit<?php echo $list['nb_produits'] > 1 ? 's' : ''; ?></span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-6 py-3 flex justify-between">
                                <a href="view_list_details.php?id=<?php echo $list['id_liste']; ?>" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>
                                <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette liste ?');">
                                    <input type="hidden" name="list_id" value="<?php echo $list['id_liste']; ?>">
                                    <button type="submit" name="delete_list" class="text-red-600 hover:text-red-800 font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Listes partagées avec moi -->
        <?php if (!empty($shared_lists)): ?>
            <section>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Listes partagées avec moi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($shared_lists as $list): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition border-l-4 <?php echo $list['role'] === 'edition' ? 'border-green-500' : 'border-blue-500'; ?>">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-blue-600 mb-2"><?php echo htmlspecialchars($list['nom_liste']); ?></h3>
                                
                                <p class="text-gray-600 mb-2">
                                    <span class="font-medium">Partagée par:</span> <?php echo htmlspecialchars($list['createur_nom']); ?>
                                </p>
                                
                                <?php if (!empty($list['cours'])): ?>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-medium">Cours:</span> <?php echo htmlspecialchars($list['cours']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <p class="text-sm text-gray-500 mb-2">
                                    Accès: <?php echo $list['role'] === 'edition' ? 'Édition' : 'Lecture seule'; ?>
                                </p>
                                
                                <div class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium"><?php echo $list['nb_produits']; ?> produit<?php echo $list['nb_produits'] > 1 ? 's' : ''; ?></span>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-6 py-3">
                                <a href="view_list_details.php?id=<?php echo $list['id_liste']; ?>&shared=1" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir la liste
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>