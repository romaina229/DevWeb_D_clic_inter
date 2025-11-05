<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livres Science-Fiction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Livres de Science-Fiction</h1>
            <a href="index.php" class="btn">← Retour à l'accueil</a>
        </header>

        <div class="content-area">
            <?php
            try {
                $conn = getConnection();
                
                $sql = "SELECT * FROM livres WHERE categorie = 'Science-fiction'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<h2>Livres de Science-fiction</h2>";
                if (count($result) > 0) {
                    echo "<div class='books-grid'>";
                    foreach ($result as $row) {
                        echo "<div class='book-card'>";
                        echo "<div class='book-image'>";
                        echo "<img src='" . secureInput($row['image']) . "' alt='" . secureInput($row['titre']) . "'>";
                        echo "</div>";
                        echo "<div class='book-info'>";
                        echo "<h3>" . secureInput($row['titre']) . "</h3>";
                        echo "<p><strong>Auteur:</strong> " . secureInput($row['auteur']) . "</p>";
                        echo "<p><strong>Année:</strong> " . secureInput($row['annee_publication']) . "</p>";
                        echo "<p><strong>Image:</strong> " . secureInput($row['image']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>Aucun livre trouvé dans la catégorie Science-fiction.</p>";
                }
                
            } catch(PDOException $e) {
                echo "<p class='error'>Erreur: " . $e->getMessage() . "</p>";
            }
            $conn = null;
            ?>
        </div>
    </div>
</body>
</html>