<?php
require_once 'config.php';

$title = "Catégories";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT DISTINCT categorie, COUNT(*) as count FROM livres GROUP BY categorie ORDER BY categorie";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>🏷️ Catégories de livres disponibles</h2>';
    
    if (count($result) > 0) {
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">';
        foreach ($result as $row) {
            echo '<div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 25px; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">';
            echo '<div style="font-size: 2.5em; margin-bottom: 15px;">📂</div>';
            echo '<h3 style="margin: 0 0 10px 0;">' . htmlspecialchars($row['categorie']) . '</h3>';
            echo '<div style="font-size: 1.5em; font-weight: bold;">' . $row['count'] . ' livre(s)</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Aucune catégorie trouvée.</div>';
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