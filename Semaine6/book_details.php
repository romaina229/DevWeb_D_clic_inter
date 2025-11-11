<?php
// book_details.php
require_once 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$book_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$book) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    $error = "Erreur lors du chargement du livre : " . $e->getMessage();
}

// Traitement de l'ajout à la liste de lecture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $lecteur_id = 1; // En attendant l'authentification
    
    try {
        // Vérifier si déjà dans la liste
        $check_stmt = $pdo->prepare("SELECT * FROM liste_lecture WHERE id_livre = ? AND id_lecteur = ?");
        $check_stmt->execute([$book_id, $lecteur_id]);
        
        if ($check_stmt->rowCount() === 0) {
            $insert_stmt = $pdo->prepare("INSERT INTO liste_lecture (id_livre, id_lecteur, date_emprunt) VALUES (?, ?, CURDATE())");
            $insert_stmt->execute([$book_id, $lecteur_id]);
            $success = "Livre ajouté à votre liste de lecture !";
        } else {
            $info = "Ce livre est déjà dans votre liste de lecture";
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
    <title><?php echo htmlspecialchars($book['titre']); ?> - Bibliothèque en Ligne</title>
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
        .book-detail { background: white; padding: 2rem; margin: 2rem 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; background: #3498db; color: white; padding: 0.8rem 1.5rem; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .btn-success { background: #2ecc71; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-info { background: #d1ecf1; color: #0c5460; }
        .footer {background-color: #2c3e50; }
		 .menu-toggle {
            display: none;
            cursor: pointer;
            }

            .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: white;
            margin-bottom: 5px;
            transition: all 0.3s;
            }

            @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                background-color: #667eea;
                width: 100%;
                padding: 20px;
				
            }
            
            .nav-links.show {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
				<div class="logo">Bibliothèque en Ligne</div>
                <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
                </div>
                
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="wishlist.php">Ma liste de lecture</a></li>
                    <li><a href="add_book.php">Ajouter un livre</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($info)): ?>
            <div class="alert alert-info"><?php echo $info; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="book-detail">
            <h1><?php echo htmlspecialchars($book['titre']); ?></h1>
            <p><strong>Auteur:</strong> <?php echo htmlspecialchars($book['auteur']); ?></p>
            <p><strong>Maison d'édition:</strong> <?php echo htmlspecialchars($book['maison_edition']); ?></p>
            <p><strong>Exemplaires disponibles:</strong> <?php echo $book['nombre_exemplaire']; ?></p>
            
            <h3>Description:</h3>
            <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
            
            <div style="margin-top: 2rem;">
                <a href="index.php" class="btn">Retour à l'accueil</a>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="add_to_wishlist" class="btn btn-success">Ajouter à ma liste de lecture</button>
                </form>
            </div>
        </div>
    </div>
	<div class="footer"><?php include 'footer.php'; ?></div>
</body>
	<script>
	//afficher le menu toggle
            function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('show');
            }
	</script>
</html>