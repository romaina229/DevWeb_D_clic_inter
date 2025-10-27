<?php
$nom = "Romain";
$age = 31;
echo "Je m'appelle $nom et j'ai $age ans.<br>";

// Calcul de l'année de naissance
$annee_actuelle = date("Y");
$annee_naissance = $annee_actuelle - $age;
echo "Je suis né en $annee_naissance.";
?>
