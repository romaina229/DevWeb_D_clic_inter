<?php
// index.php
require_once 'config.php';
session_start();

// Récupérer les livres pour l'affichage initial
try {
    $stmt = $pdo->query("SELECT * FROM livres ORDER BY date_ajout DESC LIMIT 6");
    $recent_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $recent_books = [];
    $error = "Erreur lors du chargement des livres";
}

// Traitement de la recherche si formulaire soumis
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_term = '%' . $_POST['search_term'] . '%';
    try {
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE titre LIKE ? OR auteur LIKE ? ORDER BY titre");
        $stmt->execute([$search_term, $search_term]);
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Erreur lors de la recherche : " . $e->getMessage();
    }
}

// Traitement de l'ajout à la liste de lecture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $book_id = $_POST['book_id'];
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
    <title>Bibliothèque en Ligne</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Page d'accueil -->
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

    <section class="hero">
        <div class="container">
            <h1>Bienvenue à la Bibliothèque en Ligne</h1>
            <p>Découvrez, explorez et empruntez des livres de notre vaste collection. Recherchez par titre, auteur ou genre littéraire.</p>
            <a href="#search" class="btn">Commencer la recherche</a>
        </div>
    </section>

    <!-- Messages d'alerte -->
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($info)): ?>
            <div class="alert alert-info"><?php echo $info; ?></div>
        <?php endif; ?>
    </div>

    <section class="search-section" id="search">
        <div class="container">
            <h2 class="section-title">Rechercher un livre</h2>
            <form class="search-form" method="POST">
                <input type="text" class="search-input" name="search_term" placeholder="Titre, auteur, mot-clé..." 
                       value="<?php echo isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : ''; ?>" required>
                <button type="submit" name="search" class="search-btn">Rechercher</button>
            </form>
        </div>
    </section>

    <!-- Affichage des résultats de recherche -->
    <?php if (!empty($search_results)): ?>
    <section class="books-section">
        <div class="container">
            <h2 class="section-title">Résultats de la recherche</h2>
            <div class="books-grid">
                <?php foreach ($search_results as $book): ?>
                <div class="book-card">
                    <div class="book-cover">Couverture du livre</div>
                    <div class="book-info">
                        <div class="book-title"><?php echo htmlspecialchars($book['titre']); ?></div>
                        <div class="book-author"><?php echo htmlspecialchars($book['auteur']); ?></div>
                        <div class="book-actions">
                            <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn">Voir détails</a>
                            <form method="POST" style="margin:0;">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit" name="add_to_wishlist" class="btn btn-success">Ajouter à ma liste</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="features">
        <div class="container">
            <h2 class="section-title">Fonctionnalités de notre bibliothèque</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3>Catalogue complet</h3>
                    <p>Accédez à des milliers de livres de tous genres, des classiques aux dernières nouveautés.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Recherche avancée</h3>
                    <p>Trouvez facilement les livres qui vous intéressent grâce à notre moteur de recherche performant.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">❤️</div>
                    <h3>Liste de lecture personnelle</h3>
                    <p>Créez votre propre liste de livres à lire et gérez vos emprunts facilement.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="books-section">
        <div class="container">
            <h2 class="section-title">Derniers livres ajoutés</h2>
            <div class="books-grid">
                <?php foreach ($recent_books as $book): ?>
                <div class="book-card">
                    <div class="book-cover">Couverture du livre</div>
                    <div class="book-info">
                        <div class="book-title"><?php echo htmlspecialchars($book['titre']); ?></div>
                        <div class="book-author"><?php echo htmlspecialchars($book['auteur']); ?></div>
                        <div class="book-actions">
                            <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn">Voir détails</a>
                            <form method="POST" style="margin:0;">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <button type="submit" name="add_to_wishlist" class="btn btn-success">Ajouter à ma liste</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
        <?php include 'footer.php'; ?>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('show');
            }
    </script>
</body>
</html>