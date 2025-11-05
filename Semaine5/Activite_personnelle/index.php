<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de la Bibliothèque</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            color: #4a5568;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #718096;
            font-size: 1.2em;
        }

        .nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .nav-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 5px solid #667eea;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .nav-card h3 {
            color: #4a5568;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .nav-card p {
            color: #718096;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        }

        .content-area {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-height: 400px;
        }

        .section-title {
            color: #4a5568;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: white;
            padding: 20px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2em;
            }
        }
    </style>
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
                <a href="science_fiction.php" class="btn">Voir les livres</a>
            </div>

            <div class="nav-card">
                <h3>👨‍💼 Jules Verne</h3>
                <p>Liste tous les livres écrits par Jules Verne dans un tableau avec images</p>
                <a href="jules_verne.php" class="btn">Afficher</a>
            </div>

            <!-- Mise à jour -->
            <div class="nav-card">
                <h3>✏️ Mise à Jour</h3>
                <p>Modifier l'année de publication d'un livre via un formulaire</p>
                <a href="update_livre.php" class="btn btn-warning">Modifier</a>
            </div>

            <!-- Suppression -->
            <div class="nav-card">
                <h3>🗑️ Suppression</h3>
                <p>Supprimer tous les livres de la catégorie "Romans historiques"</p>
                <a href="delete_romans.php" class="btn btn-danger">Supprimer</a>
            </div>

            <!-- Sélections diverses -->
            <div class="nav-card">
                <h3>📅 Livres récents</h3>
                <p>Affiche les livres publiés après l'année 2000</p>
                <a href="livres_apres_2000.php" class="btn">Voir</a>
            </div>

            <div class="nav-card">
                <h3>📊 Tous les livres</h3>
                <p>Tableau complet de tous les livres avec titres et auteurs</p>
                <a href="tous_les_livres.php" class="btn">Afficher tout</a>
            </div>

            <div class="nav-card">
                <h3>🔢 Statistiques</h3>
                <p>Nombre total de livres dans la bibliothèque</p>
                <a href="nombre_livres.php" class="btn">Voir le compte</a>
            </div>

            <div class="nav-card">
                <h3>📖 Top 5 livres</h3>
                <p>Les 5 premiers livres par ordre alphabétique</p>
                <a href="top5_livres.php" class="btn">Découvrir</a>
            </div>

            <div class="nav-card">
                <h3>🏷️ Catégories</h3>
                <p>Liste de toutes les catégories distinctes disponibles</p>
                <a href="categories.php" class="btn">Explorer</a>
            </div>

            <div class="nav-card">
                <h3>📅 Ajout des livres</h3>
                <p>Desirez-vous de mettre de vusibilité à vos écrits (livres ou Romans )</p>
                <a href="ajout.php" class="btn">Ajouter ici</a>
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
                    <li style="margin-bottom: 10px;">✅ ajout des livres</li>
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
            <p>Système de Gestion de Bibliothèque &copy; 2025 - tous droits réservés</p>
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