<?php
require_once 'config.php';

$title = "Mise à jour des données";
echo getHeader($title);
echo getNavigation();

$message = '';
$message_type = '';

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    try {
        $conn = getConnection();
        $sql = "UPDATE livres SET annee_publication = :annee WHERE titre = :titre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':annee', $_POST['annee_publication']);
        $stmt->bindParam(':titre', $_POST['titre']);
        $stmt->execute();
        
        $message = '✅ Mise à jour réussie ! L\'année de publication a été modifiée.';
        $message_type = 'alert-success';
        
    } catch(PDOException $e) {
        $message = '❌ Erreur: ' . $e->getMessage();
        $message_type = 'alert-danger';
    }
}

// Affichage des données actuelles
try {
    $conn = getConnection();
    $sql = "SELECT * FROM livres WHERE titre = 'Vingt mille lieues sous les mers'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>🔄 Mise à jour de l\'année de publication</h2>';
    
    if ($message) {
        echo '<div class="alert ' . $message_type . '">' . $message . '</div>';
    }
    
    if ($livre) {
        echo '<form method="POST">';
        echo '<input type="hidden" name="titre" value="' . htmlspecialchars($livre['titre']) . '">';
        
        echo '<div class="form-group">';
        echo '<label>Titre du livre:</label>';
        echo '<input type="text" value="' . htmlspecialchars($livre['titre']) . '" readonly>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label>Auteur:</label>';
        echo '<input type="text" value="' . htmlspecialchars($livre['auteur']) . '" readonly>';
        echo '</div>';
        
        echo '<div class="form-group">';
        echo '<label for="annee_publication">Année de publication:</label>';
        echo '<input type="number" name="annee_publication" value="' . htmlspecialchars($livre['annee_publication']) . '" required min="1000" max="' . date('Y') . '">';
        echo '</div>';
        
        echo '<button type="submit" name="update" class="btn btn-success">💾 Mettre à jour</button>';
        echo '</form>';
    } else {
        echo '<div class="alert alert-danger">Livre non trouvé.</div>';
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