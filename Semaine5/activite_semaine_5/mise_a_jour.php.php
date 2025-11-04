<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

// Afficher les données actuelles
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mise à jour
        $stmt = $conn->prepare("UPDATE livres SET annee_publication = :annee WHERE titre = :titre");
        $stmt->bindParam(':annee', $_POST['annee_publication']);
        $stmt->bindParam(':titre', $_POST['titre']);
        $stmt->execute();
        echo "Livre mis à jour avec succès!";
    }
    
    // Récupérer les données actuelles
    $stmt = $conn->prepare("SELECT * FROM livres WHERE titre = 'Vingt mille lieues sous les mers'");
    $stmt->execute();
    $livre = $stmt->fetch();
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mise à jour livre</title>
</head>
<body>
    <h2>Mise à jour du livre</h2>
    <form method="POST">
        <input type="hidden" name="titre" value="Vingt mille lieues sous les mers">
        
        <label>Année de publication actuelle: <?php echo $livre['annee_publication']; ?></label><br>
        <label>Nouvelle année:</label>
        <input type="number" name="annee_publication" value="1870" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>

<?php $conn = null; ?>