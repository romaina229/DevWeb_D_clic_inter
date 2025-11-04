<?php
$servername = "http://127.0.0.1/";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT titre, auteur FROM livres");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    echo "<h2>Tous les livres</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Titre</th><th>Auteur</th></tr>";
    foreach($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['titre'] . "</td>";
        echo "<td>" . $row['auteur'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>