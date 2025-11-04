<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exercices PHP Complets</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
        h1 { text-align: center; color: #333; }
        nav { text-align: center; margin-bottom: 20px; }
        a { background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; margin: 5px; display: inline-block; }
        a:hover { background: #0056b3; }
        section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { border-collapse: collapse; width: 50%; margin-top: 10px; }
        table, th, td { border: 1px solid #aaa; }
        th, td { padding: 8px; text-align: center; }
    </style>
</head>
<body>

<h1>Exercices PHP Complets</h1>

<nav>
    <a href="?exo=1">Exercice 1</a>
    <a href="?exo=2">Exercice 2</a>
    <a href="?exo=3">Exercice 3</a>
    <a href="?exo=4">Exercice 4</a>
    <a href="?exo=5">Exercice 5</a>
</nav>

<section>
<?php
$exo = isset($_GET['exo']) ? $_GET['exo'] : 1;


// EXERCICE 1

if ($exo == 1) {
    echo "<h2>Exercice 1 : Bases du PHP</h2>";

    echo "<h3>1.1 Bonjour, monde !</h3>";
    echo "Bonjour, monde !<br>";

    echo "<h3>2. Variables et opérateurs</h3>";
    $nom = "Romain";
    $age = 31;
    echo "Je m'appelle $nom et j'ai $age ans.<br>";
    $annee_naissance = date("Y") - $age;
    echo "Je suis né en $annee_naissance.<br>";

    echo "<h3>3. Structures de contrôle</h3>";
    if ($age >= 18) echo "Vous êtes majeur.<br>"; else echo "Vous êtes mineur.<br>";
    for ($i = 1; $i <= 10; $i++) echo "$i ";

    echo "<h3>4. Fonctions</h3>";
    function somme($a, $b) { return $a + $b; }
    echo "<p>Somme de 5 et 10 = " . somme(5, 10) . "</p>";

    function tableauHTML($personnes) {
        echo "<table><tr><th>Nom</th><th>Âge</th></tr>";
        foreach ($personnes as $nom => $age) echo "<tr><td>$nom</td><td>$age</td></tr>";
        echo "</table>";
    }
    $personnes = ["Alice" => 22, "Bob" => 30, "Charlie" => 19];
    tableauHTML($personnes);

    echo "<h3>5. Manipulation de fichiers</h3>";
    $fichier = "message.txt";
    file_put_contents($fichier, "Ceci est un message écrit depuis PHP.\n");
    echo nl2br(file_get_contents($fichier));
}


// EXERCICE 2

elseif ($exo == 2) {
    echo "<h2>Exercice 2 : Tableau de notes</h2>";

    $notes = [12, 18, 9, 14, 16];
    echo "Notes : " . implode(", ", $notes) . "<br>";
    echo "Note maximale : " . max($notes) . "<br>";
    echo "Note minimale : " . min($notes) . "<br>";

    $moyenne = array_sum($notes) / count($notes);
    echo "Moyenne : " . number_format($moyenne, 2) . "<br>";

    rsort($notes);
    echo "Notes triées (décroissant) : " . implode(", ", $notes);
}


// EXERCICE 3

elseif ($exo == 3) {
    echo "<h2>Exercice 3 : Tableaux et Fonctions</h2>";

    $nombres = [];
    for ($i = 0; $i < 10; $i++) $nombres[] = rand(1, 100);

    function afficherTableau($tab) { echo implode(", ", $tab) . "<br>"; }
    function sommeTableau($tab) { return array_sum($tab); }
    function moyenneTableau($tab) { return array_sum($tab) / count($tab); }
    function nombrePairs($tab) {
        $nb = 0;
        foreach ($tab as $n) if ($n % 2 == 0) $nb++;
        return $nb;
    }

    echo "<p>Tableau : "; afficherTableau($nombres);
    echo "Somme : " . sommeTableau($nombres) . "<br>";
    echo "Moyenne : " . moyenneTableau($nombres) . "<br>";
    echo "Nombres pairs : " . nombrePairs($nombres) . "</p>";
}


//  EXERCICE 4

elseif ($exo == 4) {
    echo "<h2>Exercice 4 : Noms Complets</h2>";

    $nomsComplets = ["Alice Dupont", "Bob Martin", "Claire Zinsou", "David Kouassi", "Emma Dossa"];

    function afficherNoms($tab) { foreach ($tab as $n) echo "$n<br>"; }
    function nomEnMajuscules($nom) { return strtoupper($nom); }
    function prenomNom($nomComplet) { return explode(" ", $nomComplet); }

    echo "<h3>Noms complets :</h3>";
    afficherNoms($nomsComplets);

    echo "<h3>Noms en majuscules :</h3>";
    foreach ($nomsComplets as $n) echo nomEnMajuscules($n) . "<br>";

    echo "<h3>Prénoms :</h3>";
    foreach ($nomsComplets as $n) {
        $parts = prenomNom($n);
        echo "Prénom : " . $parts[0] . "<br>";
    }
}


// EXERCICE 5 : Formulaires GET et POST

elseif ($exo == 5) {
    echo "<h2>Exercice 5 : Formulaires PHP</h2>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        echo "<h3>Données reçues (POST)</h3>";
        echo "Nom : $nom<br>Email : $email<br><br>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nom']) && isset($_GET['email'])) {
        $nom = $_GET['nom'];
        $email = $_GET['email'];
        echo "<h3>Données reçues (GET)</h3>";
        echo "Nom : $nom<br>Email : $email<br><br>";
    }

    echo '<h3>Formulaire POST</h3>
    <form method="POST">
        Nom : <input type="text" name="nom"><br>
        Email : <input type="email" name="email"><br>
        <input type="submit" value="Envoyer (POST)">
    </form><br>';

    echo '<h3>Formulaire GET</h3>
    <form method="GET">
        <input type="hidden" name="exo" value="5">
        Nom : <input type="text" name="nom"><br>
        Email : <input type="email" name="email"><br>
        <input type="submit" value="Envoyer (GET)">
    </form>';
}
?>
</section>
</body>
</html>
