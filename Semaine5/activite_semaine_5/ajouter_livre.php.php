<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bibliotheque_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertion des livres
    $sql = "INSERT INTO livres (titre, auteur, annee_publication, categorie, image) VALUES 
            ('Vingt mille lieues sous les mers', 'Jules Verne', 1869, 'Science-fiction', 'vingt_mille_lieues.jpg'),
            ('Le Tour du monde en 80 jours', 'Jules Verne', 1872, 'Aventure', 'tour_monde.jpg'),
            ('Fondation', 'Isaac Asimov', 1951, 'Science-fiction', 'fondation.jpg')";
    
    $conn->exec($sql);
    echo "Livres insérés avec succès";
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
$conn = null;
?>