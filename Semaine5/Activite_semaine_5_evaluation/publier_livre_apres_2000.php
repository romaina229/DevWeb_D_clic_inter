<?php
// 6.1 - Livres après 2000
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT titre, annee_publication FROM livres WHERE annee_publication > 2000 ORDER BY annee_publication";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Livres publiés après 2000</h2>";
    echo "<ul>";
    foreach ($result as $row) {
        echo "<li><strong>" . htmlspecialchars($row['titre']) . "</strong> (" . htmlspecialchars($row['annee_publication']) . ")</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>