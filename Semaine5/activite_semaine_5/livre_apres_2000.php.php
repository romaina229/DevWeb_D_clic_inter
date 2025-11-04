<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT * FROM livres WHERE auteur = 'Jules Verne'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    echo "<h2>Livres de Jules Verne</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Titre</th><th>Image</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['titre'] . "</td>";
        echo "<td><img src='" . $row['image'] . "' alt='" . $row['titre'] . "' width='100'></td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>