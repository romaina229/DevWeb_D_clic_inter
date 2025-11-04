<?php
$servername = "http://127.0.0.1/";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("SELECT DISTINCT categorie FROM livres");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    echo "<h2>Catégories de livres</h2>";
    echo "<ul>";
    foreach($result as $row) {
        echo "<li>" . $row['categorie'] . "</li>";
    }
    echo "</ul>";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>