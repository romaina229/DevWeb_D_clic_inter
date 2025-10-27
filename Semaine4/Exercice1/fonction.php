<?php
// Fonction somme
function somme($a, $b) {
    return $a + $b;
}
echo "Somme : " . somme(5, 10) . "<br>";

// Générer un tableau HTML
function tableauHTML($personnes) {
    echo "<table border='1'>";
    echo "<tr><th>Nom</th><th>Âge</th></tr>";
    foreach ($personnes as $nom => $age) {
        echo "<tr><td>$nom</td><td>$age</td></tr>";
    }
    echo "</table>";
}

$personnes = [
    "Géraldine" => 23,
    "Joie" => 30,
    "Charlie" => 19
];

tableauHTML($personnes);
?>
