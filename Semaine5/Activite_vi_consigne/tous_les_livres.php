<?php
require_once 'config.php';

$title = "Tous les livres";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT titre, auteur, annee_publication, categorie FROM livres ORDER BY auteur, titre";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>📚 Tous les livres de la bibliothèque</h2>';
    
    if (count($result) > 0) {
        echo '<table>';
        echo '<tr><th>Titre</th><th>Auteur</th><th>Année</th><th>Catégorie</th></tr>';
        
        foreach ($result as $row) {
            echo '<tr>';
            echo '<td><strong>' . htmlspecialchars($row['titre']) . '</strong></td>';
            echo '<td>' . htmlspecialchars($row['auteur']) . '</td>';
            echo '<td>' . htmlspecialchars($row['annee_publication']) . '</td>';
            echo '<td><span style="background: #3498db; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8em;">' . htmlspecialchars($row['categorie']) . '</span></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<div class="alert alert-danger">Aucun livre trouvé dans la base de données.</div>';
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