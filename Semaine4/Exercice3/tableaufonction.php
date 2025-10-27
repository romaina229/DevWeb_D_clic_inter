<?php
// Génération du tableau
$nombres = [];
for ($i = 0; $i < 10; $i++) {
    $nombres[] = rand(1, 100);
}

// Fonctions
function afficherTableau($tab) {
    echo implode(", ", $tab) . "<br>";
}

function sommeTableau($tab) {
    return array_sum($tab);
}

function moyenneTableau($tab) {
    return array_sum($tab) / count($tab);
}

function nombrePairs($tab) {
    $compte = 0;
    foreach ($tab as $n) {
        if ($n % 2 == 0) $compte++;
    }
    return $compte;
}

// Utilisation
echo "Tableau : ";
afficherTableau($nombres);
echo "Somme : " . sommeTableau($nombres) . "<br>";
echo "Moyenne : " . moyenneTableau($nombres) . "<br>";
echo "Nombres pairs : " . nombrePairs($nombres);
?>
