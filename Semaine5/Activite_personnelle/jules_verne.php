<?php
require_once 'config.php';

$title = "Livres de Jules Verne";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    $sql = "SELECT * FROM livres WHERE auteur = 'Jules Verne'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>👨‍💼 Livres de Jules Verne</h2>';
    
    if (count($result) > 0) {
        echo '<table>';
        echo '<tr><th>Titre</th><th>Année</th><th>Image</th></tr>';
        
        foreach ($result as $row) {
            echo '<tr>';
            echo '<td><strong>' . htmlspecialchars($row['titre']) . '</strong></td>';
            echo '<td>' . htmlspecialchars($row['annee_publication']) . '</td>';
            echo '<td>';
            if (!empty($row['image'])) {
                echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['titre']) . '" class="book-image">';
            } else {
                echo '🖼️ Aucune image';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<div class="alert alert-danger">Aucun livre de Jules Verne trouvé.</div>';
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