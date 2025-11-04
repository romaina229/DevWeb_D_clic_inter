<?php
$servername = "http://127.0.0.1/";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT titre FROM livres ORDER BY titre ASC LIMIT 5");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    echo "<h2>5 premiers livres par ordre alphabétique</h2>";
    echo "<ol>";
    foreach($result as $row) {
        echo "<li>" . $row['titre'] . "</li>";
    }
    echo "</ol>";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>