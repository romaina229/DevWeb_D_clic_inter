function appliquerTheme(theme) {
  localStorage.setItem("themeChoisi", theme);
  const body = document.getElementById("maPage");
  body.className = theme;
}

function changerTexte() {
  const nouveauTexte = document.getElementById("nouveauTexte").value;
  const paragraphe = document.getElementById("texte");

  if (nouveauTexte.trim() !== "") {
    paragraphe.textContent = nouveauTexte;
    localStorage.setItem("paragrapheSauvegarde", nouveauTexte);
    document.getElementById("nouveauTexte").value = "";
  } else {
    alert("Veuillez saisir un texte avant de valider.");
  }
}

function ajouterEcouteursEvenements() {
  document.getElementById("b1").addEventListener("click", () => appliquerTheme("jour"));
  document.getElementById("b2").addEventListener("click", () => appliquerTheme("nuit"));
  document.getElementById("b3").addEventListener("click", () => appliquerTheme("ocean"));
  document.getElementById("b4").addEventListener("click", () => appliquerTheme("foret"));
  document.getElementById("changerTexte").addEventListener("click", changerTexte);
}

function initialiser() {
  const themeSauvegarde = localStorage.getItem("themeChoisi");
  const texteSauvegarde = localStorage.getItem("paragrapheSauvegarde");

  if (themeSauvegarde) {
    appliquerTheme(themeSauvegarde);
  } else {
    appliquerTheme("jour");
  }

  if (texteSauvegarde) {
    document.getElementById("texte").textContent = texteSauvegarde;
  }

  ajouterEcouteursEvenements();
}

initialiser();
