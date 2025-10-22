// Validation du nom (au moins 2 lettres, peut inclure espaces et tirets)
function verifiernom() {
    const nomEl = document.getElementById('C1') || document.getElementById('nom');
    const nom = nomEl ? nomEl.value.trim() : '';
    const regex = /^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]{2,}$/;
    if (regex.test(nom)) {
        alert('Nom valide');
        return true;
    } else {
        alert('Nom invalide — utilisez au moins 2 lettres');
        return false;
    }
}

// Validation de l'adresse (au moins 5 caractères)
function verifieradresse() {
    const adresseEl = document.getElementById('C2') || document.getElementById('adresse');
    const adresse = adresseEl ? adresseEl.value.trim() : '';
    const regex = /^.{5,}$/;
    if (regex.test(adresse)) {
        alert('Adresse valide');
        return true;
    } else {
        alert('Adresse invalide — au moins 5 caractères');
        return false;
    }
}

// Validation code postal (4 chiffres)
function verifierpostal() {
    const codeEl = document.getElementById('C3') || document.getElementById('no_postal');
    const code = codeEl ? codeEl.value.trim() : '';
    const regex = /^[0-9]{4}$/;
    if (regex.test(code)) {
        alert('Code postal valide');
        return true;
    } else {
        alert('Code postal invalide — format attendu : 4 chiffres');
        return false;
    }
}

// Ajoute le pays saisi dans la liste <select id="lepays"> et affiche un message
function myFunction() {
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
    const civilite = form.civilite ? form.civilite.value : '';
    const nom = form.nom ? form.nom.value : '';
    const adresse = form.adresse ? form.adresse.value : '';
    const no_postal = form.no_postal ? form.no_postal.value : '';
    const localite = form.localite ? form.localite.value : '';
    const pays = form.pays ? form.pays.value : '';
    alert(`Résumé:\nCivilité: ${civilite}\nNom: ${nom}\nAdresse: ${adresse}\nCode postal: ${no_postal}\nLocalité: ${localite}\nPays: ${pays}`);
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