<?php
// 5.1 - Suppression Romans historiques
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

// Vérification avant suppression
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
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
            
            echo "<p style='color: green;'>" . count($livres_a_supprimer) . " livre(s) de la catégorie 'Romans historiques' ont été supprimés.</p>";
            
            // Afficher les livres supprimés
            echo "<h3>Livres supprimés:</h3>";
            echo "<ul>";
            foreach ($livres_a_supprimer as $livre) {
                echo "<li>" . htmlspecialchars($livre['titre']) . " - " . htmlspecialchars($livre['auteur']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun livre dans la catégorie 'Romans historiques' trouvé.</p>";
        }
        
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    // Formulaire de confirmation
    echo "<h2>Suppression des Romans historiques</h2>";
    echo "<p>Êtes-vous sûr de vouloir supprimer tous les livres de la catégorie 'Romans historiques' ?</p>";
    echo "<form method='POST'>";
    echo "<button type='submit' name='confirm_delete' style='background-color: red; color: white; padding: 10px;'>Confirmer la suppression</button>";
    echo "</form>";
}

$conn = null;
?>