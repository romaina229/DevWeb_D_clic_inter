<?php
require_once 'config.php';

$title = "Ajouter un nouveau livre";
echo getHeader($title);
echo getNavigation();

echo '<div class="content">';
echo '<div class="card">';
echo '<h2>📖 Ajouter un nouveau livre</h2>';

echo '<form action="ajouter.php" method="POST">';
echo '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">';

echo '<div class="form-group">';
echo '<label for="titre">Titre du livre *</label>';
echo '<input type="text" id="titre" name="titre" required placeholder="Ex: Vingt mille lieues sous les mers">';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="auteur">Auteur *</label>';
echo '<input type="text" id="auteur" name="auteur" required placeholder="Ex: Jules Verne">';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="annee_publication">Année de publication *</label>';
echo '<input type="number" id="annee_publication" name="annee_publication" required min="1000" max="' . date('Y') . '" placeholder="Ex: 1870">';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="categorie">Catégorie *</label>';
echo '<select id="categorie" name="categorie" required>';
echo '<option value="">Sélectionnez une catégorie</option>';
echo '<option value="Science-fiction">Science-fiction</option>';
echo '<option value="Roman">Roman</option>';
echo '<option value="Fantasy">Fantasy</option>';
echo '<option value="Dystopie">Dystopie</option>';
echo '<option value="Aventure">Aventure</option>';
echo '<option value="Historique">Historique</option>';
echo '<option value="Policier">Policier</option>';
echo '<option value="Biographie">Biographie</option>';
echo '<option value="Poésie">Poésie</option>';
echo '<option value="Théâtre">Théâtre</option>';
echo '</select>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="image">Nom du fichier image</label>';
echo '<input type="text" id="image" name="image" placeholder="Ex: livre1.jpg">';
echo '<small style="color: #666;">Placez l\'image dans le dossier "images/"</small>';
echo '</div>';

echo '</div>';

echo '<div class="form-group" style="margin-top: 20px;">';
echo '<button type="submit" name="ajouter" class="btn btn-success" style="padding: 15px 30px; font-size: 18px;">';
echo '➕ Ajouter le livre';
echo '</button>';
echo '<a href="javascript:history.back()" class="btn" style="margin-left: 10px;">↩️ Annuler</a>';
echo '</div>';

echo '</form>';
echo '</div>';
echo '</div>';

echo getFooter();
?>