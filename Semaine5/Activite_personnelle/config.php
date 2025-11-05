<?php
// config.php - Configuration et styles
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

function getConnection() {
    global $servername, $username, $password, $dbname;
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Erreur de connexion: " . $e->getMessage());
    }
}

function getHeader($title) {
    return '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . htmlspecialchars($title) . '</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 20px;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                overflow: hidden;
            }
            .header {
                background: linear-gradient(135deg, #2c3e50, #34495e);
                color: white;
                padding: 30px;
                text-align: center;
            }
            .header h1 {
                font-size: 2.5em;
                margin-bottom: 10px;
            }
            .content {
                padding: 40px;
            }
            .card {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 25px;
                margin-bottom: 25px;
                border-left: 5px solid #3498db;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            th, td {
                padding: 15px;
                text-align: left;
                border-bottom: 1px solid #e0e0e0;
            }
            th {
                background: #3498db;
                color: white;
                font-weight: 600;
            }
            tr:hover {
                background: #f5f5f5;
            }
            .btn {
                background: linear-gradient(135deg, #3498db, #2980b9);
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            .btn-danger {
                background: linear-gradient(135deg, #e74c3c, #c0392b);
            }
            .btn-success {
                background: linear-gradient(135deg, #27ae60, #229954);
            }
            .form-group {
                margin-bottom: 20px;
            }
            label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: #2c3e50;
            }
            input, select, textarea {
                width: 100%;
                padding: 12px;
                border: 2px solid #e0e0e0;
                border-radius: 6px;
                font-size: 16px;
                transition: border 0.3s ease;
            }
            input:focus, select:focus, textarea:focus {
                border-color: #3498db;
                outline: none;
            }
            .alert {
                padding: 15px;
                border-radius: 6px;
                margin: 20px 0;
            }
            .alert-success {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }
            .alert-danger {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
            .book-image {
                width: 80px;
                height: 100px;
                object-fit: cover;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }
            .stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin: 30px 0;
            }
            .stat-card {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                padding: 25px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            .stat-number {
                font-size: 3em;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .navigation {
                background: #ecf0f1;
                padding: 20px;
                border-bottom: 1px solid #bdc3c7;
            }
            .nav-links {
                display: flex;
                gap: 15px;
                flex-wrap: wrap;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>📚 ' . htmlspecialchars($title) . '</h1>
                <p>Système de gestion de bibliothèque</p>
            </div>
    ';
}

function getFooter() {
    return '
            <div style="background: #2c3e50; color: white; text-align: center; padding: 20px; margin-top: 40px;">
                <p>&copy; 2024 Bibliothèque - Tous droits réservés</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

function getNavigation() {
    return '
    <div class="navigation">
        <div class="nav-links">
            <a href="index.php" class="btn">Acceuil</a>
            <a href="science_fiction.php" class="btn">Science-fiction</a>
            <a href="jules_verne.php" class="btn">Jules Verne</a>
            <a href="update_livre.php" class="btn">Mise à jour</a>
            <a href="delete_romans.php" class="btn btn-danger">Suppression</a>
            <a href="ajout.php" class="btn btn-danger">Ajouter</a>
            <a href="livres_apres_2000.php" class="btn">Livres après 2000</a>
            <a href="tous_les_livres.php" class="btn">Tous les livres</a>
            <a href="nombre_livres.php" class="btn">Statistiques</a>
            <a href="top5_livres.php" class="btn">Top 5 livres</a>
            <a href="categories.php" class="btn">Catégories</a>
        </div>
    </div>
    ';
}
?>