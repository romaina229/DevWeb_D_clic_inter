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

// Traitement de l'ajout d'un nouveau livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $description = trim($_POST['description']);
    $maison_edition = trim($_POST['maison_edition']);
    $nombre_exemplaire = intval($_POST['nombre_exemplaire']);
    
    // Validation
    if (empty($titre) || empty($auteur)) {
        $error = "Le titre et l'auteur sont obligatoires";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire) 
                                  VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $auteur, $description, $maison_edition, $nombre_exemplaire]);
            
            $success = "Livre ajouté avec succès !";
            
            // Recharger les livres récents
            $stmt = $pdo->query("SELECT * FROM livres ORDER BY date_ajout DESC LIMIT 8");
            $recent_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout : " . $e->getMessage();
        }
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

    <!-- Section avec onglets pour Recherche et Ajout de livre -->
    <section class="search-section" id="search">
        <div class="container">
            

            <!-- Onglet Recherche -->
            <div id="search-tab" class="tab-content active">
                <h2 class="section-title">🔍Rechercher un livre</h2>
                <form class="search-form" method="POST">
                    <input type="text" class="search-input" name="search_term" placeholder="Titre, auteur, mot-clé..." 
                           value="<?php echo isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : ''; ?>" required>
                    <button type="submit" name="search" class="search-btn">Rechercher</button>
                </form>
            </div><br>

            <!-- Onglet Ajout de livre -->
            <div id="add-tab" class="tab-content">
                <h2 class="section-title">📚Ajouter un nouveau livre</h2>
                <div class="add-book-section">
                    <form method="POST">
                        <div class="form-group">
                            <label for="titre">Titre *</label>
                            <input type="text" id="titre" name="titre" 
                                   value="<?php echo isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="auteur">Auteur *</label>
                            <input type="text" id="auteur" name="auteur" 
                                   value="<?php echo isset($_POST['auteur']) ? htmlspecialchars($_POST['auteur']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Description du livre..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="maison_edition">Maison d'édition</label>
                                <input type="text" id="maison_edition" name="maison_edition" 
                                       value="<?php echo isset($_POST['maison_edition']) ? htmlspecialchars($_POST['maison_edition']) : ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="nombre_exemplaire">Nombre d'exemplaires</label>
                                <input type="number" id="nombre_exemplaire" name="nombre_exemplaire" 
                                       value="<?php echo isset($_POST['nombre_exemplaire']) ? $_POST['nombre_exemplaire'] : 1; ?>" min="1">
                            </div>
                        </div>
                        
                        <button type="submit" name="add_book" class="btn btn-success">Ajouter le livre</button>
                    </form>
                </div>
            </div>
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
                    <div class="book-cover">📖</div>
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
                    <div class="book-cover">📖</div>
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
        // Fonction pour gérer les onglets
        function openTab(tabName) {
            // Masquer tous les contenus d'onglets
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            
            // Désactiver tous les onglets
            var tabs = document.getElementsByClassName('tab');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            
            // Activer l'onglet sélectionné
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Si on a soumis le formulaire d'ajout, rester sur l'onglet d'ajout
        <?php if (isset($_POST['add_book'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                openTab('add-tab');
            });
            <?php endif; ?> 
			//afficher le menu toggle
            function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('show');
            }
    </script>
</body>
</html>