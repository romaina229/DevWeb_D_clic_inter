<?php
// 7.1 - Tous les livres (titres et auteurs)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT titre, auteur FROM livres ORDER BY auteur, titre";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Tous les livres</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Titre</th><th>Auteur</th></tr>";
    
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['auteur']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>