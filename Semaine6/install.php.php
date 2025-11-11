<?php
// install.php - Script d'installation automatique
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation de la Bibliothèque</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; padding: 10px; background: #f0fff0; border: 1px solid green; }
        .error { color: red; padding: 10px; background: #fff0f0; border: 1px solid red; }
        .info { color: blue; padding: 10px; background: #f0f0ff; border: 1px solid blue; }
    </style>
</head>
<body>
    <h1>Installation de la Bibliothèque en Ligne</h1>
    
    <?php
    // Paramètres de connexion
    $host = 'localhost';
    $username = 'root';
    $password = '';
    
    try {
        // Connexion à MySQL sans sélectionner de base
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Lecture du fichier SQL
        $sql = file_get_contents('create_database.sql');
        
        // Exécution des requêtes
        $pdo->exec($sql);
        
        echo '<div class="success">';
        echo '<h2>✅ Installation réussie !</h2>';
        echo '<p>La base de données a été créée avec succès avec :</p>';
        echo '<ul>';
        echo '<li>10 livres d\'exemple</li>';
        echo '<li>10 lecteurs d\'exemple</li>';
        echo '<li>Des emprunts de test</li>';
        echo '</ul>';
        echo '<p>Vous pouvez maintenant <a href="index.php">accéder à la bibliothèque</a>.</p>';
        echo '</div>';
        
    } catch (PDOException $e) {
        echo '<div class="error">';
        echo '<h2>❌ Erreur lors de l\'installation</h2>';
        echo '<p><strong>Message d\'erreur :</strong> ' . $e->getMessage() . '</p>';
        echo '<p>Veuillez vérifier :</p>';
        echo '<ul>';
        echo '<li>Que MySQL est démarré</li>';
        echo '<li>Les paramètres de connexion dans install.php</li>';
        echo '<li>Que l\'utilisateur MySQL a les droits suffisants</li>';
        echo '</ul>';
        echo '</div>';
    }
    ?>
    
    <div class="info">
        <h3>Prochaines étapes :</h3>
        <ol>
            <li>Vérifiez que le fichier config.php a les bons paramètres de connexion</li>
            <li>Accédez à <a href="index.php">index.php</a> pour tester l'application</li>
            <li>Supprimez le fichier install.php pour des raisons de sécurité</li>
        </ol>
    </div>
</body>
</html>

