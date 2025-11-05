<?php
require_once 'config.php';

$title = "Top 5 livres";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT titre, auteur, annee_publication FROM livres ORDER BY titre LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>⭐ Les 5 premiers livres puliés par ordre alphabétique</h2>';
    
    if (count($result) > 0) {
        echo '<div style="display: grid; gap: 15px; margin-top: 20px;">';
        $rank = 1;
        foreach ($result as $row) {
            $bg_color = $rank == 1 ? '#ffd700' : ($rank == 2 ? '#c0c0c0' : ($rank == 3 ? '#cd7f32' : '#3498db'));
            echo '<div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid ' . $bg_color . '; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">';
            echo '<div style="background: ' . $bg_color . '; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">' . $rank . '</div>';
            echo '<div style="flex: 1;">';
            echo '<h3 style="margin: 0 0 5px 0; color: #2c3e50;">' . htmlspecialchars($row['titre']) . '</h3>';
            echo '<p style="margin: 0; color: #7f8c8d;">' . htmlspecialchars($row['auteur']) . ' • ' . htmlspecialchars($row['annee_publication']) . '</p>';
            echo '</div>';
            echo '</div>';
            $rank++;
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Aucun livre trouvé.</div>';
    }
    
    echo '</div>';
    echo '</div>';
    
} catch(PDOException $e) {
    echo '<div class="content">';
    echo '<div class="alert alert-danger">Erreur: ' . $e->getMessage() . '</div>';
    echo '</div>';
}

echo getFooter();
?>script