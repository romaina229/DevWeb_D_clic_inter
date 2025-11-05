<?php
// 4.1 - Mise à jour année publication
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "UPDATE livres SET annee_publication = :annee WHERE titre = :titre";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':annee', $_POST['annee_publication']);
        $stmt->bindParam(':titre', $_POST['titre']);
        $stmt->execute();
        
        echo "<p style='color: green;'>Mise à jour réussie !</p>";
        
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// Affichage des données actuelles
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM livres WHERE titre = 'Vingt mille lieues sous les mers'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($livre) {
        echo "<h2>Mise à jour de l'année de publication</h2>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='titre' value='" . htmlspecialchars($livre['titre']) . "'>";
        echo "<p><strong>Titre:</strong> " . htmlspecialchars($livre['titre']) . "</p>";
        echo "<p><strong>Auteur:</strong> " . htmlspecialchars($livre['auteur']) . "</p>";
        echo "<label for='annee_publication'>Année de publication:</label>";
        echo "<input type='number' name='annee_publication' value='" . htmlspecialchars($livre['annee_publication']) . "' required>";
        echo "<br><br>";
        echo "<button type='submit' name='update'>Mettre à jour</button>";
        echo "</form>";
    }
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>