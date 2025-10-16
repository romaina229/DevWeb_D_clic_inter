// Initialise la carte Leaflet dans la div #map
const coordonnees = document.getElementById('coordonnees');

const map = L.map('map', {
  center: [48.8566, 2.3522], // Paris par défaut
  zoom: 5,
  zoomControl: true
});

// Couche OpenStreetMap (affiche noms de villes/pays)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let marker = null;
const positionSpan = document.getElementById('position');

function setMarker(lat, lon, text) {
  if (marker) {
    marker.setLatLng([lat, lon]);
  } else {
    marker = L.marker([lat, lon]).addTo(map);
  }
  if (text) marker.bindPopup(text).openPopup();
}

// Reverse geocoding via Nominatim (OpenStreetMap)
async function reverseGeocode(lat, lon) {
  try {
    const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;
    const res = await fetch(url, {
      headers: {
        'Accept': 'application/json',
        'User-Agent': 'Projet_Canvas_Geoloc/1.0 (contact@example.com)'
      }
    });
    if (!res.ok) return null;
    const data = await res.json();
    return data;
  } catch (e) {
    console.error('Reverse geocode error', e);
    return null;
  }
}

function savePosition(lat, lon) {
  localStorage.setItem('latitude', lat);
  localStorage.setItem('longitude', lon);
}

// Récupération depuis le stockage local si disponible
window.onload = function() {
  const lat = localStorage.getItem('latitude');
  const lon = localStorage.getItem('longitude');
  if (lat && lon) {
    coordonnees.textContent = `Dernière position : ${lat}, ${lon}`;
    const latf = parseFloat(lat);
    const lonf = parseFloat(lon);
    // try to get a human readable name
    reverseGeocode(latf, lonf).then((data) => {
      const label = data && (data.display_name || data.address && (data.address.city || data.address.town || data.address.village || data.address.country))
        ? (data.display_name || `${data.address.city || data.address.town || data.address.village}, ${data.address.country || ''}`)
        : 'Dernière position enregistrée';
      setMarker(latf, lonf, label);
      positionSpan.textContent = label;
      map.setView([latf, lonf], 13);
    }).catch(() => {
      setMarker(latf, lonf, "Dernière position enregistrée");
      positionSpan.textContent = `${lat}, ${lon}`;
      map.setView([latf, lonf], 13);
    });
  }
};

// Fonction principale de géolocalisation
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((pos) => {
      const lat = parseFloat(pos.coords.latitude.toFixed(6));
      const lon = parseFloat(pos.coords.longitude.toFixed(6));

      coordonnees.textContent = `Latitude : ${lat}, Longitude : ${lon}`;
      savePosition(lat, lon);
      // get human readable address and show in popup
      reverseGeocode(lat, lon).then((data) => {
        const label = data && (data.display_name || data.address && (data.address.city || data.address.town || data.address.village || data.address.country))
          ? (data.display_name || `${data.address.city || data.address.town || data.address.village}, ${data.address.country || ''}`)
          : 'Vous êtes ici !';
        setMarker(lat, lon, label);
        positionSpan.textContent = label;
        map.setView([lat, lon], 13);
      }).catch(() => {
        setMarker(lat, lon, "Vous êtes ici !");
        positionSpan.textContent = `${lat}, ${lon}`;
        map.setView([lat, lon], 13);
      });
    }, (error) => {
      coordonnees.textContent = "Erreur de géolocalisation : " + error.message;
    }, {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 0
    });
  } else {
    coordonnees.textContent = "La géolocalisation n’est pas supportée par ce navigateur.";
  }
}