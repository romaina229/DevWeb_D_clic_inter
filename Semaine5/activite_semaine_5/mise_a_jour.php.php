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
        echo "<p style= 'color:green;'>Livre mis à jour avec succès!</p>";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        h2 {
            color: #2E8B57;
            text-align: center;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="number"] {
            margin: 10px 0;
            padding: 5px;
        }
        button {
            background-color: #2E8B57;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3CB371;
        }
    </style>
</head>
<body>
    <h2>Mise à jour de l'année de année publication</h2>
    <form method="POST">
        <input type="hidden" name="titre" value="Vingt mille lieues sous les mers">
        <p><strong>Titre :</strong> <?php echo htmlspecialchars($livre['titre']); ?></p>
        <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
        <label for="annee_publication">Année de publication actuelle: <?php echo $livre['annee_publication']; ?></label><br>
        <label for="annee_publication">Nouvelle année:</label>
        <input type="number" name="annee_publication" value="<?php echo htmlspecialchars($livre['annee_publication']); ?>" required>
        <button type="submit" name="update">Mettre à jour</button>
    </form>
</body>
</html>

<?php $conn = null; ?>