  <?php
// search_resultats.php
//afficher les resultats des recherche ici 
require_once 'config.php';
session_start();

// Traitement de la recherche si formulaire soumis
$search_results = [];
if (isset($_GET['search_term'])) {
    $search_term = '%' . $_GET['search_term'] . '%';
    try {
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE titre LIKE ? OR auteur LIKE ? ORDER BY titre");
        $stmt->execute([$search_term, $search_term]);
        $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Erreur lors de la recherche : " . $e->getMessage();
    }
}

// Traitement de l'ajout à la liste de lecture
if (isset($_GET['add_to_wishlist'])) {
    $book_id = $_GET['book_id'];
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
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #2ecc71;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
			color: #667eea;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 1.5rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--secondary-color);
        }
        
        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('https://source.unsplash.com/random/1200x600/?library') no-repeat center center/cover;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--secondary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        .btn-danger {
            background-color: var(--accent-color);
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-success {
            background-color: var(--success-color);
        }
        
        .btn-success:hover {
            background-color: #27ae60;
        }
        
        .search-section {
            background-color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .search-form {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
        }
        
        .search-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 0 1.5rem;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        
        .features {
            padding: 3rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .books-section {
            padding: 3rem 0;
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .book-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .book-cover {
            height: 200px;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
        }
        
        .book-info {
            padding: 1.5rem;
        }
        
        .book-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .book-author {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .book-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .book-actions form {
            margin: 0;
        }
        
        .book-actions .btn {
            width: 100%;
            text-align: center;
        }
        
        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        /* Styles pour le formulaire d'ajout */
        .add-book-section {
            background-color: white;
            padding: 2rem;
            margin: 2rem 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
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
        /*style pour le resultats de la recherche */
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }
        .books-section {
            padding: 3rem 0;
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .book-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .book-cover {
            height: 200px;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
        }
        
        .book-info {
            padding: 1.5rem;
        }
        
        .book-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .book-author {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .book-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .book-actions form {
            margin: 0;
        }
        
        .book-actions .btn {
            width: 100%;
            text-align: center;
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
        <!-- Affichage des résultats de recherche -->
<?php if (!empty($search_results)): ?>
    <section class="books-section">
        <div class="container">
            <h2 class="section-title">Résultats de la recherche</h2>
            <div class="books-grid">
                <?php foreach ($search_results as $book): ?>
                    <div class="book-card">
                        <div class="book-cover"> 📖 Couverture du livre</div>
                        <div class="book-info">
                            <div class="book-title"><?php echo htmlspecialchars($book['titre']); ?></div>
                            <div class="book-author"><?php echo htmlspecialchars($book['auteur']); ?></div>
                            <div class="book-actions">
                                <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn">Voir détails</a>
                                <form method="GET" style="margin:0;" action="wishlist.php">
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
<?php else: ?>
    <p>Aucun résultat trouvé.</p>
<?php endif; ?>
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