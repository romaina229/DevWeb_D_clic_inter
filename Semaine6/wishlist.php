<?php
// wishlist.php
require_once 'config.php';
session_start();

$lecteur_id = 1; // En attendant l'authentification

// Récupérer la liste de lecture
try {
    $stmt = $pdo->prepare("SELECT l.*, ll.date_emprunt, ll.date_retour, ll.id as wishlist_id 
                          FROM livres l 
                          INNER JOIN liste_lecture ll ON l.id = ll.id_livre 
                          WHERE ll.id_lecteur = ? 
                          ORDER BY ll.date_emprunt DESC");
    $stmt->execute([$lecteur_id]);
    $wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors du chargement de la liste : " . $e->getMessage();
    $wishlist = [];
}

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_wishlist'])) {
    $wishlist_id = $_POST['wishlist_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM liste_lecture WHERE id = ? AND id_lecteur = ?");
        $stmt->execute([$wishlist_id, $lecteur_id]);
        
        if ($stmt->rowCount() > 0) {
            $success = "Livre retiré de votre liste de lecture";
            // Recharger la liste
            header("Location: wishlist.php");
            exit();
        } else {
            $error = "Erreur lors de la suppression";
        }
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Liste de Lecture - Bibliothèque en Ligne</title>
    <style>
        /* Reprendre le CSS de index.php */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f5f7fa; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        header { background-color: #2c3e50; color: white; padding: 1rem 0; }
        nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.8rem; font-weight: bold; }
        .nav-links { display: flex; list-style: none; }
        .nav-links li { margin-left: 1.5rem; }
        .nav-links a { color: white; text-decoration: none; }
        .section-title { text-align: center; margin: 2rem 0; color: #2c3e50; }
        .wishlist-item { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; background: #e74c3c; color: white; padding: 0.5rem 1rem; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">Bibliothèque en Ligne</div>
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="wishlist.php">Ma liste de lecture</a></li>
                    <li><a href="add_book.php">Ajouter un livre</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1 class="section-title">Ma Liste de Lecture</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (empty($wishlist)): ?>
            <p style="text-align: center;">Votre liste de lecture est vide.</p>
        <?php else: ?>
            <?php foreach ($wishlist as $item): ?>
            <div class="wishlist-item">
                <h3><?php echo htmlspecialchars($item['titre']); ?></h3>
                <p><strong>Auteur:</strong> <?php echo htmlspecialchars($item['auteur']); ?></p>
                <p><strong>Date d'emprunt:</strong> <?php echo $item['date_emprunt']; ?></p>
                <?php if ($item['date_retour']): ?>
                    <p><strong>Date de retour:</strong> <?php echo $item['date_retour']; ?></p>
                <?php endif; ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="wishlist_id" value="<?php echo $item['wishlist_id']; ?>">
                    <button type="submit" name="remove_from_wishlist" class="btn">Retirer de la liste</button>
                </form>
                <a href="book_details.php?id=<?php echo $item['id']; ?>" style="margin-left: 10px;">Voir détails</a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>