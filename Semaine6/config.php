<?php
// config.php - Configuration de la connexion à la base de données

// Paramètres de connexion
$host = 'localhost';
$dbname = 'bibliotheque';
$username = 'root';
$password = '';


// Options PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message et arrêter le script
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction utilitaire pour sécuriser les données
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fonction pour logger les erreurs
function log_error($message) {
    error_log(date('Y-m-d H:i:s') . " - " . $message . "\n", 3, "error_log.txt");
}
?>