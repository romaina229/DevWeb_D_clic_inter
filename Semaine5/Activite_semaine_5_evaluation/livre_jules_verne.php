<?php
// 3.2 - Livres Jules Verne avec images
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM livres WHERE auteur = 'Jules Verne'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Livres de Jules Verne</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Titre</th><th>Image</th></tr>";
    
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['titre']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['titre']) . "' width='100'></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>