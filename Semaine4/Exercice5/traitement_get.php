<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nom = $_GET['nom'];
    $email = $_GET['email'];
    echo "Nom : $nom<br>";
    echo "Email : $email";
}
?>
