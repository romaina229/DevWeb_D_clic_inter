<?php
require_once 'config.php';

$title = "Livres après 2000";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT titre, annee_publication, auteur FROM livres WHERE annee_publication > 2000 ORDER BY annee_publication DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>🚀 Livres publiés après 2000</h2>';
    
    if (count($result) > 0) {
        echo '<div style="display: grid; gap: 15px; margin-top: 20px;">';
        foreach ($result as $row) {
            echo '<div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #27ae60; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
            echo '<div style="display: flex; justify-content: between; align-items: center;">';
            echo '<div style="flex: 1;">';
            echo '<h3 style="margin: 0 0 5px 0; color: #2c3e50;">' . htmlspecialchars($row['titre']) . '</h3>';
            echo '<p style="margin: 0; color: #7f8c8d;">Par ' . htmlspecialchars($row['auteur']) . '</p>';
            echo '</div>';
            echo '<div style="background: #27ae60; color: white; padding: 10px 15px; border-radius: 20px; font-weight: bold;">';
            echo htmlspecialchars($row['annee_publication']);
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Aucun livre publié après 2000 trouvé.</div>';
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