
Document explicatif du projet : Application Web Interactive

Titre du projet

Application Web Interactive : Graphique dynamique et géolocalisation de l’utilisateur

---
1. Objectif du projet

L’objectif de cette activité est de mettre en pratique les connaissances sur :

* les API HTML avancées,
* les éléments CSS avancés,
* et la création de graphiques à l’aide de l’élément <canvas>.

Le projet consiste à créer une **application web interactive** qui permet à l’utilisateur :

1. D’ajouter des valeurs numériques et de visualiser leur évolution sur un graphique.
2. De connaître sa position géographique actuelle à l’aide de l’API de géolocalisation.
3. De conserver les données dans le navigateur grâce à l’API de stockage Web.
---
2. Technologies utilisées

* HTML5 : structure du document, champ de saisie, boutons, canvas.
* CSS3 avancé :

  * Dégradés de fond,
  * Animations (@keyframes),
  * Flexbox pour la disposition,
  * Pseudo-classes (:hover).
* *JavaScript : logique interactive du site.
* *API HTML5 utilisées :

  1. API de stockage Web (localStorage) : pour enregistrer les données saisies et les restaurer même après le rechargement de la page.
  2. API de géolocalisation : pour afficher la latitude et la longitude de l’utilisateur.
* Canvas API : pour créer un graphique dynamique en JavaScript.
---
3. Description du fonctionnement

1. L’utilisateur entre une valeur numérique dans un champ de saisie.
2. En cliquant sur le bouton “Ajouter”, la valeur est :

   * ajoutée dans le tableau de données,
   * enregistrée dans le *localStorage*,
   * affichée sous forme de *barre dans un graphique* dessiné sur le <canvas>.
3. En cliquant sur le bouton **“Ma position”**, l’application :

   * demande l’autorisation de l’utilisateur,
   * récupère les coordonnées GPS (latitude, longitude),
   * les affiche à l’écran.
4. Même après actualisation de la page, les données du graphique restent visibles grâce au stockage local.

---
4. Structure du projet

📁 Projet_Canvas_Geoloc/
│
├── index.html        → Les deux pages principales contenant les codes HTML
│
├── assets/           → Dossier pour les fichiers css
└── js/		      → Dossier pour les fichiers JavaScript
└── README.txt        → Document explicatif du projet

---
5. Code principal (résumé)

Le cœur du projet est basé sur trois fonctions JavaScript :

js
// Ajout de données et stockage
function addData() { ... }

// Dessin du graphique sur le canvas
function drawGraph() { ... }

// Récupération de la position de l'utilisateur
function showLocation() { ... }


Le *localStorage* est utilisé ainsi :

js
localStorage.setItem('myData', JSON.stringify(data));


Et le *canvas* est utilisé pour dessiner :

js
ctx.fillRect(x, y, barWidth, data[i]);

---
6. Résultats attendus

L’application doit :

* Afficher un *graphique dynamique* mis à jour à chaque ajout.
* Enregistrer les données localement.
* Montrer la *géolocalisation* de l’utilisateur.
* Avoir une *interface claire et animée* grâce au CSS.

---
7. Améliorations possibles

* Intégrer une *carte interactive* (Google Maps ou Leaflet).
* Ajouter un *choix du type de graphique* (barres, lignes, secteurs).
* Permettre la **suppression ou la modification* de valeurs.
* Adapter le design pour les *mobiles*.

---
8. Conclusion

Ce projet démontre comment combiner plusieurs technologies web modernes pour créer une application interactive et conviviale.
L’utilisation des *API HTML5* (Stockage Web et Géolocalisation) permet de rendre la page intelligente et dynamique, tandis que *Canvas* et *CSS avancé* apportent une touche visuelle professionnelle.