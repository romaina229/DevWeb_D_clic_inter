// Fonction principale : applique un thème et le sauvegarde
function appliquerTheme(theme) {
  // Sauvegarde du thème choisi
  localStorage.setItem("themeChoisi", theme);

  // Récupère l'élément <body> via son id
  const body = document.getElementById("maPage");

  // Supprime les classes précédentes (jour/nuit)
  body.classList.remove("jour", "nuit");

  // Ajoute la nouvelle classe correspondant au thème
  body.classList.add(theme);
}

// Fonctions spécifiques pour chaque bouton
function appliquerThemeJour() {
  appliquerTheme("jour");
}

function appliquerThemeNuit() {
  appliquerTheme("nuit");
}

// Ajoute les écouteurs sur les boutons
function ajouterEcouteursEvenements() {
  document.getElementById("b1").addEventListener("click", appliquerThemeJour);
  document.getElementById("b2").addEventListener("click", appliquerThemeNuit);
}

// Fonction d'initialisation au chargement de la page
function initialiser() {
  // Récupère le thème précédemment sauvegardé
  const themeSauvegarde = localStorage.getItem("themeChoisi");

  if (themeSauvegarde) {
    appliquerTheme(themeSauvegarde);
  } else {
    appliquerTheme("jour");
  }

  // Ajoute les écouteurs après avoir appliqué le thème
  ajouterEcouteursEvenements();
}

// Appel de la fonction principale au chargement de la page
initialiser();
