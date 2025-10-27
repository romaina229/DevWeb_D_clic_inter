<?php
$nomsComplets = ["Alice Dupont", "Bob Martin", "Claire Zinsou", "David Kouassi", "Emma Dossa"];

function afficherNoms($tab) {
    foreach ($tab as $nom) {
        echo $nom . "<br>";
    }
}

function nomEnMajuscules($nom) {
    return strtoupper($nom);
}

function prenomNom($nomComplet) {
    return explode(" ", $nomComplet);
}

// Utilisation
echo "<h3>Noms complets :</h3>";
afficherNoms($nomsComplets);

echo "<h3>Noms en majuscules :</h3>";
foreach ($nomsComplets as $n) {
    echo nomEnMajuscules($n) . "<br>";
}

echo "<h3>Prénoms :</h3>";
foreach ($nomsComplets as $n) {
    $parts = prenomNom($n);
    echo "Prénom : " . $parts[0] . "<br>";
}
?>
