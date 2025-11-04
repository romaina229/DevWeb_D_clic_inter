<?php
// 10.1 - Catégories distinctes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT DISTINCT categorie FROM livres ORDER BY categorie";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Catégories de livres disponibles</h2>";
    echo "<ul>";
    foreach ($result as $row) {
        echo "<li>" . htmlspecialchars($row['categorie']) . "</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>