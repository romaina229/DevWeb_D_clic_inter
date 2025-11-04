<?php
$servername = "http://127.0.0.1/";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare("DELETE FROM livres WHERE categorie = 'Romans historiques'");
    $stmt->execute();
    
    echo $stmt->rowCount() . " livres supprimés avec succès";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>