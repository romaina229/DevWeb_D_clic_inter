<?php
require_once 'config.php';

$title = "Livres de Science-fiction";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT * FROM livres WHERE categorie = 'Science-fiction'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>📖 Livres de Science-fiction</h2>';
    echo '<p>Liste des fichiers images des livres de science-fiction :</p>';
    
    if (count($result) > 0) {
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">';
        foreach ($result as $row) {
            echo '<div style="background: white; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
            echo '<div style="font-size: 2em; margin-bottom: 10px;">🖼️</div>';
            echo '<strong>'. htmlspecialchars($row['image']) . '</strong>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Aucun livre de science-fiction trouvé.</div>';
    }
    
    echo '</div>';
    echo '</div>';
    
} catch(PDOException $e) {
    echo '<div class="content">';
    echo '<div class="alert alert-danger">Erreur: ' . $e->getMessage() . '</div>';
    echo '</div>';
}

echo getFooter();
?>