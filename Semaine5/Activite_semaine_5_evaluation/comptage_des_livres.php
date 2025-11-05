<?php
// 8.1 - Comptage des livres
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT COUNT(*) as total FROM livres";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h2>Nombre total de livres dans la bibliothèque</h2>";
    echo "<p style='font-size: 24px; color: blue;'>" . $result['total'] . " livre(s)</p>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>