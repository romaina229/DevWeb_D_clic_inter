<?php
require_once 'config.php';

$title = "Ajout de livre - Résultat";
echo getHeader($title);
echo getNavigation();

echo '<div class="content">';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
    
    // Récupération et validation des données (version compatible)
    $titre = isset($_POST['titre']) ? trim($_POST['titre']) : '';
    $auteur = isset($_POST['auteur']) ? trim($_POST['auteur']) : '';
    $annee_publication = isset($_POST['annee_publication']) ? $_POST['annee_publication'] : '';
    $categorie = isset($_POST['categorie']) ? trim($_POST['categorie']) : '';
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    
    // Validation des champs obligatoires
    $erreurs = array();
    
    if (empty($titre)) {
        $erreurs[] = "Le titre est obligatoire";
    }
    
    if (empty($auteur)) {
        $erreurs[] = "L'auteur est obligatoire";
    }
    
    if (empty($annee_publication)) {
        $erreurs[] = "L'année de publication est obligatoire";
    } elseif (!is_numeric($annee_publication) || $annee_publication < 1000 || $annee_publication > date('Y')) {
        $erreurs[] = "L'année de publication doit être comprise entre 1000 et " . date('Y');
    }
    
    if (empty($categorie)) {
        $erreurs[] = "La catégorie est obligatoire";
    }
    
    // Si il y a des erreurs, les afficher
    if (!empty($erreurs)) {
        echo '<div class="card">';
        echo '<div class="alert alert-danger">';
        echo '<h3>❌ Erreurs de validation</h3>';
        echo '<ul>';
        foreach ($erreurs as $erreur) {
            echo '<li>' . htmlspecialchars($erreur) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<a href="ajout.php" class="btn">↩️ Retour au formulaire</a>';
        echo '</div>';
    } else {
        // Tentative d'insertion dans la base de données
        try {
            $conn = getConnection();
            
            // Préparation de la requête SQL
            $sql = "INSERT INTO livres (titre, auteur, annee_publication, categorie, image) 
                    VALUES (:titre, :auteur, :annee_publication, :categorie, :image)";
            
            $stmt = $conn->prepare($sql);
            
            // Liaison des paramètres
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':annee_publication', $annee_publication);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':image', $image);
            
            // Exécution de la requête
            $resultat = $stmt->execute();
            
            if ($resultat) {
                echo '<div class="card">';
                echo '<div class="alert alert-success">';
                echo '<h3>✅ Livre ajouté avec succès !</h3>';
                echo '<p>Le livre a été ajouté à la base de données.</p>';
                echo '</div>';
                
                // Afficher les détails du livre ajouté
                echo '<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">';
                echo '<h4>📋 Détails du livre ajouté :</h4>';
                echo '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">';
                echo '<div><strong>Titre :</strong> ' . htmlspecialchars($titre) . '</div>';
                echo '<div><strong>Auteur :</strong> ' . htmlspecialchars($auteur) . '</div>';
                echo '<div><strong>Année :</strong> ' . htmlspecialchars($annee_publication) . '</div>';
                echo '<div><strong>Catégorie :</strong> ' . htmlspecialchars($categorie) . '</div>';
                if (!empty($image)) {
                    echo '<div><strong>Image :</strong> ' . htmlspecialchars($image) . '</div>';
                }
                echo '</div>';
                echo '</div>';
                
                echo '<div style="display: flex; gap: 15px; flex-wrap: wrap;">';
                echo '<a href="ajout.php" class="btn btn-success">➕ Ajouter un autre livre</a>';
                echo '<a href="tous_les_livres.php" class="btn">📚 Voir tous les livres</a>';
                echo '<a href="index.php" class="btn">🏠 Retour à l\'accueil</a>';
                echo '</div>';
                echo '</div>';
                
            } else {
                throw new Exception("Erreur lors de l'insertion dans la base de données");
            }
            
        } catch (PDOException $e) {
            echo '<div class="card">';
            echo '<div class="alert alert-danger">';
            echo '<h3>❌ Erreur lors de l\'ajout</h3>';
            echo '<p><strong>Erreur MySQL :</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
            
            // Aide au débogage
            if (strpos($e->getMessage(), 'base de données') !== false) {
                echo '<p>💡 <strong>Conseil :</strong> Vérifiez que la base de données "bibliotheque_db" et la table "livres" existent.</p>';
            } elseif (strpos($e->getMessage(), 'table') !== false) {
                echo '<p>💡 <strong>Conseil :</strong> La table "livres" n\'existe pas. Créez-la avec la structure requise.</p>';
            } elseif (strpos($e->getMessage(), 'Column') !== false) {
                echo '<p>💡 <strong>Conseil :</strong> Vérifiez que toutes les colonnes existent dans la table.</p>';
            }
            
            echo '</div>';
            echo '<a href="ajout.php" class="btn">↩️ Retour au formulaire</a>';
            echo '</div>';
        }
    }
    
} else {
    // Si quelqu'un accède directement à ajouter.php sans formulaire
    echo '<div class="card">';
    echo '<div class="alert alert-danger">';
    echo '<h3>❌ Accès non autorisé</h3>';
    echo '<p>Vous devez passer par le formulaire d\'ajout pour ajouter un livre.</p>';
    echo '</div>';
    echo '<a href="ajout.php" class="btn">📖 Aller au formulaire d\'ajout</a>';
    echo '</div>';
}

echo '</div>';
echo getFooter();
?>