<?php
// 3.1 - Livres Science-fiction
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM livres WHERE categorie = 'Science-fiction'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Livres de Science-fiction</h2>";
    echo "<ul>";
    foreach ($result as $row) {
        echo "<li>" . htmlspecialchars($row['image']) . "</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>