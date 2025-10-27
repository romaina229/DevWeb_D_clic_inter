<?php
$fichier = "message.txt";

// Écriture dans un fichier
file_put_contents($fichier, "Ceci est un message écrit depuis PHP.\n");

// Lecture et affichage du contenu
$contenu = file_get_contents($fichier);
echo nl2br($contenu);
?>
