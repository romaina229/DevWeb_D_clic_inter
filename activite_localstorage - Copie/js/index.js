function appliquerTheme(theme) {
  localStorage.setItem("themeChoisi", theme);
  const body = document.getElementById("maPage");
  body.className = theme; // Applique la classe du thème directement
}

function ajouterEcouteursEvenements() {
  document.getElementById("b1").addEventListener("click", () => appliquerTheme("jour"));
  document.getElementById("b2").addEventListener("click", () => appliquerTheme("nuit"));
  document.getElementById("b3").addEventListener("click", () => appliquerTheme("ocean"));
  document.getElementById("b4").addEventListener("click", () => appliquerTheme("foret"));
}

function initialiser() {
  const themeSauvegarde = localStorage.getItem("themeChoisi");
  if (themeSauvegarde) {
    appliquerTheme(themeSauvegarde);
  } else {
    appliquerTheme("jour");
  }
  ajouterEcouteursEvenements();
}

initialiser();
