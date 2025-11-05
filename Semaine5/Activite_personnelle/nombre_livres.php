<?php
require_once 'config.php';

$title = "Statistiques";
echo getHeader($title);
echo getNavigation();

try {
    $conn = getConnection();
    
    // Nombre total de livres
    $sql_total = "SELECT COUNT(*) as total FROM livres";
    $stmt = $conn->prepare($sql_total);
    $stmt->execute();
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Nombre par catégorie
    $sql_categories = "SELECT categorie, COUNT(*) as count FROM livres GROUP BY categorie";
    $stmt = $conn->prepare($sql_categories);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Livre le plus récent
    $sql_recent = "SELECT titre, annee_publication FROM livres ORDER BY annee_publication DESC LIMIT 1";
    $stmt = $conn->prepare($sql_recent);
    $stmt->execute();
    $recent = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>📊 Statistiques de la bibliothèque</h2>';
    
    echo '<div class="stats">';
    echo '<div class="stat-card">';
    echo '<div class="stat-number">' . $total['total'] . '</div>';
    echo '<div>Livres au total</div>';
    echo '</div>';
    
    echo '<div class="stat-card">';
    echo '<div class="stat-number">' . count($categories) . '</div>';
    echo '<div>Catégories</div>';
    echo '</div>';
    
    if ($recent) {
        echo '<div class="stat-card">';
        echo '<div class="stat-number">' . $recent['annee_publication'] . '</div>';
        echo '<div>Dernier livre</div>';
        echo '<small>' . htmlspecialchars($recent['titre']) . '</small>';
        echo '</div>';
    }
    echo '</div>';
    
    // Détails par catégorie
    echo '<h3 style="margin-top: 30px;">📈 Répartition par catégorie</h3>';
    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px;">';
    foreach ($categories as $categorie) {
        $percentage = round(($categorie['count'] / $total['total']) * 100);
        echo '<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
        echo '<div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">';
        echo '<strong>' . htmlspecialchars($categorie['categorie']) . '</strong>';
        echo '<span style="background: #3498db; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8em;">' . $categorie['count'] . ' livres</span>';
        echo '</div>';
        echo '<div style="background: #ecf0f1; height: 10px; border-radius: 5px; overflow: hidden;">';
        echo '<div style="background: linear-gradient(135deg, #3498db, #2980b9); height: 100%; width: ' . $percentage . '%;"></div>';
        echo '</div>';
        echo '<div style="text-align: right; font-size: 0.8em; color: #7f8c8d; margin-top: 5px;">' . $percentage . '%</div>';
        echo '</div>';
    }
    echo '</div>';
    
    echo '</div>';
    echo '</div>';
    
} catch(PDOException $e) {
    echo '<div class="content">';
    echo '<div class="alert alert-danger">Erreur: ' . $e->getMessage() . '</div>';
    echo '</div>';
}

echo getFooter();
?>script9