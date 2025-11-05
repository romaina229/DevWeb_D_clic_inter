<?php
require_once 'config.php';

$title = "Suppression de livres";
echo getHeader($title);
echo getNavigation();

// Vérification avant suppression
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $conn = getConnection();
        
        // Afficher les livres à supprimer
        $sql_select = "SELECT * FROM livres WHERE categorie = 'Romans historiques'";
        $stmt = $conn->prepare($sql_select);
        $stmt->execute();
        $livres_a_supprimer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($livres_a_supprimer) > 0) {
            // Suppression
            $sql_delete = "DELETE FROM livres WHERE categorie = 'Romans historiques'";
            $stmt = $conn->prepare($sql_delete);
            $stmt->execute();
            
            echo '<div class="content">';
            echo '<div class="card">';
            echo '<div class="alert alert-success">';
            echo '<h3>✅ Suppression réussie</h3>';
            echo '<p>' . count($livres_a_supprimer) . ' livre(s) de la catégorie "Romans historiques" ont été supprimés.</p>';
            echo '</div>';
            
            echo '<h3>📚 Livres supprimés:</h3>';
            echo '<div style="display: grid; gap: 10px; margin-top: 20px;">';
            foreach ($livres_a_supprimer as $livre) {
                echo '<div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 4px solid #e74c3c;">';
                echo '<strong>' . htmlspecialchars($livre['titre']) . '</strong> - ' . htmlspecialchars($livre['auteur']);
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="content">';
            echo '<div class="alert alert-danger">Aucun livre dans la catégorie "Romans historiques" trouvé.</div>';
            echo '</div>';
        }
        
    } catch(PDOException $e) {
        echo '<div class="content">';
        echo '<div class="alert alert-danger">Erreur: ' . $e->getMessage() . '</div>';
        echo '</div>';
    }
} else {
    // Formulaire de confirmation
    echo '<div class="content">';
    echo '<div class="card">';
    echo '<h2>🗑️ Suppression des Romans historiques</h2>';
    echo '<div class="alert alert-danger">';
    echo '<h3>⚠️ Attention</h3>';
    echo '<p>Êtes-vous sûr de vouloir supprimer tous les livres de la catégorie "Romans historiques" ?</p>';
    echo '<p><strong>Cette action est irréversible !</strong></p>';
    echo '</div>';
    echo '<form method="POST">';
    echo '<button type="submit" name="confirm_delete" class="btn btn-danger">🗑️ Confirmer la suppression</button>';
    echo '<a href="javascript:history.back()" class="btn" style="margin-left: 10px;">↩️ Annuler</a>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}

echo getFooter();
?>