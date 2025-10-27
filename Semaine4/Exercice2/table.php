<?php
$notes = [12, 18, 9, 14, 16];

// Note max et min
echo "Note maximale : " . max($notes) . "<br>";
echo "Note minimale : " . min($notes) . "<br>";

// Moyenne
$moyenne = array_sum($notes) / count($notes);
echo "Moyenne : " . number_format($moyenne, 2) . "<br>";

// Tri décroissant
rsort($notes);
echo "Notes triées (décroissant) : " . implode(", ", $notes);
?>
