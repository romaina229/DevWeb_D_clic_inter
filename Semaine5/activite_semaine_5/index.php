<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de la Bibliothèque</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Gestion de la Bibliothèque</h1>
            <p class="subtitle">Système de gestion de base de données des livres</p>
            
            <?php
            // Connexion pour les stats
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "bibliotheque_db";
            
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Stats globales
                $sql_total = "SELECT COUNT(*) as total FROM livres";
                $stmt_total = $conn->prepare($sql_total);
                $stmt_total->execute();
                $total_livres = $stmt_total->fetch(PDO::FETCH_ASSOC);
                
                $sql_categories = "SELECT COUNT(DISTINCT categorie) as categories FROM livres";
                $stmt_cat = $conn->prepare($sql_categories);
                $stmt_cat->execute();
                $total_categories = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                
                $sql_auteurs = "SELECT COUNT(DISTINCT auteur) as auteurs FROM livres";
                $stmt_aut = $conn->prepare($sql_auteurs);
                $stmt_aut->execute();
                $total_auteurs = $stmt_aut->fetch(PDO::FETCH_ASSOC);
                
            } catch(PDOException $e) {
                $total_livres['total'] = 0;
                $total_categories['categories'] = 0;
                $total_auteurs['auteurs'] = 0;
            }
            ?>
            
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_livres['total']; ?></div>
                    <div class="stat-label">Livres Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_categories['categories']; ?></div>
                    <div class="stat-label">Catégories</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_auteurs['auteurs']; ?></div>
                    <div class="stat-label">Auteurs</div>
                </div>
            </div>
        </header>

        <div class="nav-grid">
            <!-- Interrogation de données -->
            <div class="nav-card">
                <h3>🔍 Science-Fiction</h3>
                <p>Affiche tous les livres de la catégorie Science-Fiction avec leurs images</p>
                <a href="categorie_science_fiction.php" class="btn">Voir les livres</a>
            </div>

            <div class="nav-card">
                <h3>👨‍💼 Jules Verne</h3>
                <p>Liste tous les livres écrits par Jules Verne dans un tableau avec images</p>
                <a href="livre_jules_verne.php" class="btn">Afficher</a>
            </div>

            <!-- Mise à jour -->
            <div class="nav-card">
                <h3>✏️ Mise à Jour</h3>
                <p>Modifier l'année de publication d'un livre via un formulaire</p>
                <a href="mise_a_jour.php" class="btn btn-warning">Modifier</a>
            </div>

            <!-- Suppression -->
            <div class="nav-card">
                <h3>🗑️ Suppression</h3>
                <p>Supprimer tous les livres de la catégorie "Romans historiques"</p>
                <a href="supression_historique_livres.php" class="btn btn-danger">Supprimer</a>
            </div>

            <!-- Sélections diverses -->
            <div class="nav-card">
                <h3>📅 Livres récents</h3>
                <p>Affiche les livres publiés après l'année 2000</p>
                <a href="publier_livre_apres_2000.php" class="btn">Voir</a>
            </div>

            <div class="nav-card">
                <h3>📊 Tous les livres</h3>
                <p>Tableau complet de tous les livres avec titres et auteurs</p>
                <a href="tous_les_livre.php" class="btn">Afficher tout</a>
            </div>

            <div class="nav-card">
                <h3>🔢 Statistiques</h3>
                <p>Nombre total de livres dans la bibliothèque</p>
                <a href="comptage_des_livres.php" class="btn">Voir le compte</a>
            </div>

            <div class="nav-card">
                <h3>📖 Top 5 livres</h3>
                <p>Les 5 premiers livres par ordre alphabétique</p>
                <a href="5_premier_livre.php" class="btn">Découvrir</a>
            </div>

            <div class="nav-card">
                <h3>🏷️ Catégories</h3>
                <p>Liste de toutes les catégories distinctes disponibles</p>
                <a href="categories_distinctes_diponibles.php" class="btn">Explorer</a>
            </div>
        </div>

        <div class="content-area">
            <h2 class="section-title">Bienvenue dans votre bibliothèque numérique</h2>
            <p>Sélectionnez une option dans le menu ci-dessus pour gérer votre collection de livres.</p>
            
            <div style="margin-top: 30px; padding: 20px; background: #f7fafc; border-radius: 10px;">
                <h3 style="color: #4a5568; margin-bottom: 15px;">Fonctionnalités disponibles :</h3>
                <ul style="columns: 2; list-style-type: none; color: #718096;">
                    <li style="margin-bottom: 10px;">✅ Consultation par catégorie</li>
                    <li style="margin-bottom: 10px;">✅ Recherche par auteur</li>
                    <li style="margin-bottom: 10px;">✅ Mise à jour des informations</li>
                    <li style="margin-bottom: 10px;">✅ Suppression de données</li>
                    <li style="margin-bottom: 10px;">✅ Filtrage par année</li>
                    <li style="margin-bottom: 10px;">✅ Statistiques globales</li>
                    <li style="margin-bottom: 10px;">✅ Navigation alphabétique</li>
                    <li style="margin-bottom: 10px;">✅ Gestion des catégories</li>
                </ul>
            </div>
        </div>

        <footer>
            <p>Système de Gestion de Bibliothèque &copy; 2025 - tous droits reservés</p>
        </footer>
    </div>

    <?php
    // Fermer la connexion
    if(isset($conn)) {
        $conn = null;
    }
    ?>
</body>
</html>