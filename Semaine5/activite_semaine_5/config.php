<?php
// config.php - Configuration de la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

function getConnection() {
    global $servername, $username, $password, $dbname;
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Erreur de connexion: " . $e->getMessage());
    }
}
?>