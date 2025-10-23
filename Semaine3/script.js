//dans mon code ici j'ai utilisé des || pour gérer les deux versions des ids (C1, C2, C3...) et (nom, adresse, no_postal...). cher tuteur, j'ai intégré des css classes pour indiquer visuellement la validité des champs (par exemple, en ajoutant une bordure verte pour valide et rouge pour invalide). aussi, j'ai ajoutédes des fonctions pour afficher des notifications visuelles en plus des alertes d'erreur, afin d'améliorer l'expérience utilisateur. Pour me permettre de mieux comprendre le fonctionnement des formulaires et la validation côté client en JavaScript.

// Cependant, cher tuteur, Veuillez me mettre en commentaire dans l'espace dépôt des exercices la méthode la plus appropriée pour afficher une validation visuelle des champs de formulaire.

// cher tuteur j'ai faille solliciter votre aide pour la recupération des villes suivant le critère 3000 ou 4000 pour le choix respectivement des ville 1 ou ville 2. justement je n'ai pas fait attention à id=C4 de la localité.


// Fonction de validation générale
// Affiche un message d'erreur inline pour un champ (élément input/textarea/select)
function showError(champ, message) {
    if (!champ) return;
    // retire ancienne erreur
    clearError(champ);
    champ.classList.add('error');
    champ.classList.remove('valid');
    champ.style.border = '2px solid #ff4d4d';
    const span = document.createElement('span');
    span.className = 'error-message';
    span.style.color = '#ff1313';
    span.style.marginLeft = '8px';
    span.textContent = message;
    // insérer après le champ
    if (champ.nextSibling) {
        champ.parentNode.insertBefore(span, champ.nextSibling);
    } else {
        champ.parentNode.appendChild(span);
    }
}

// Supprime le message d'erreur pour un champ
function clearError(champ) {
    if (!champ) return;
    champ.classList.remove('error');
    champ.classList.add('valid');
    champ.style.border = '2px solid #4CAF50';
    // retirer span.error-message adjacent
    let next = champ.nextSibling;
    // skip text nodes
    while (next && next.nodeType === Node.TEXT_NODE) next = next.nextSibling;
    if (next && next.classList && next.classList.contains('error-message')) {
        next.parentNode.removeChild(next);
    }
}

// Validation du nom (8 à 20 lettres, espaces et traits d'union autorisés)
function verifiernom() {
    const nomEl = document.getElementById('C1') || document.getElementById('nom');
    const nom = nomEl ? nomEl.value.trim() : '';
    const regex = /^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]{8,20}$/;
    if (regex.test(nom)) {
        clearError(nomEl);
        return true;
    } else {
        showError(nomEl, 'Nom invalide — au moins 8 caractères et 20 caractères au plus');
        return false;
    }
}

// Validation de l'adresse (au moins 20 caractères)
function verifieradresse() {
    const adresseEl = document.getElementById('C2') || document.getElementById('adresse');
    const adresse = adresseEl ? adresseEl.value.trim() : '';
    const regex = /^.{20,}$/;
    if (regex.test(adresse)) {
        clearError(adresseEl);
        return true;
    } else {
        showError(adresseEl, 'Adresse invalide — au moins 20 caractères');
        return false;
    }
}

// Validation code postal (4 chiffres)
function verifierpostal() {
    const codeEl = document.getElementById('C3') || document.getElementById('no_postal');
    const code = codeEl ? codeEl.value.trim() : '';
    // Accept seulement les valeurs exactes 3000 ou 4000
    const localiteEl = document.getElementById('C4') || document.getElementById('localite');
    if (code === '3000') {
        if (localiteEl) localiteEl.value = 'ville1 : Abomey-Calavi';
        clearError(codeEl);
        return true;
    } else if (code === '4000') {
        if (localiteEl) localiteEl.value = 'ville2 : Cotonou';
        clearError(codeEl);
        return true;
    } else {
        if (localiteEl) localiteEl.value = '';
        showError(codeEl, 'Code postal invalide — la valeur doit être 3000 ou 4000');
        return false;
    }
}

// Ajoute le pays saisi dans la liste <select id="lepays"> et affiche un message
function ajouterPays() {
    const input = document.getElementById('C5');
    const select = document.getElementById('lepays');
    if (!input || !select) return;
    const value = input.value.trim();
    if (!value) {
        alert('Veuillez saisir un pays à ajouter');
        return;
    }
    const option = document.createElement('option');
    option.text = value;
    option.value = value;
    select.add(option);  
    alert('Pays ajouté : ' + value); 
    input.value = '';
}

// Affiche la sélection courante du select lepays
function afficherSelection() {
    const select = document.getElementById('lepays');
    if (!select) return alert('Liste des pays introuvable');
    const selectedOption = select.options[select.selectedIndex];
    alert('Pays sélectionné : ' + (selectedOption ? selectedOption.text : 'Aucun'));
}

// Affiche un résumé du formulaire (utilisé par le bouton Soumettre)
function afficher() {
    const form = document.forms[0];
    if (!form) return;
    const civilite = form.civilite ? form.civilite.value : 'Bonjour';
    const nom = form.nom ? form.nom.value : '';
    const adresse = form.adresse ? form.adresse.value : '';
    const no_postal = form.no_postal ? form.no_postal.value : '';
    const localite = form.localite ? form.localite.value : '';
    const pays = form.pays ? form.pays.value : '';
    alert(`Résumé:\n Bonjour ${civilite} ${nom} \nAdresse: ${adresse}\nCode postal: ${no_postal}\nLocalité: ${localite}\nPays: ${pays}`);
}

// Fonction de vérification globale (pour bouton Vérification formulaire)
function forme() {
    const okNom = verifiernom();
    const okAdresse = verifieradresse();
    const okPostal = verifierpostal();
    if (okNom && okAdresse && okPostal) {
        alert('Formulaire validé');
    } else {
        alert('Formulaire invalide — corrigez les champs et réessayez');
    }
}

// Enregistrer le formulaire dans localStorage
function enregistre() {
    const form = document.forms[0];
    if (!form) return;
    const data = {
        civilite: form.civilite ? form.civilite.value : '',
        nom: form.nom ? form.nom.value : '',
        adresse: form.adresse ? form.adresse.value : '',
        no_postal: form.no_postal ? form.no_postal.value : '',
        localite: form.localite ? form.localite.value : '',
        pays: form.pays ? form.pays.value : '',
        applications: Array.from(form.applications ? form.applications.options : []).filter(o => o.selected).map(o => o.value || o.text)
    };
    localStorage.setItem('formClient', JSON.stringify(data));
    alert('Formulaire enregistré');
}

// Récupérer le formulaire depuis localStorage
function recuperer() {
    const raw = localStorage.getItem('formClient');
    if (!raw) return alert('Aucune donnée enregistrée');
    const data = JSON.parse(raw);
    const form = document.forms[0];
    if (!form) return;
    if (form.civilite) form.civilite.value = data.civilite || '';
    if (form.nom) form.nom.value = data.nom || '';
    if (form.adresse) form.adresse.value = data.adresse || '';
    if (form.no_postal) form.no_postal.value = data.no_postal || '';
    if (form.localite) form.localite.value = data.localite || '';
    if (form.pays) form.pays.value = data.pays || '';
    // applications (multi)
    if (form.applications) {
        Array.from(form.applications.options).forEach(opt => {
            opt.selected = (data.applications || []).includes(opt.value || opt.text);
        });
    }
    alert('Données récupérées');
}