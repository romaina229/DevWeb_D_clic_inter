CREATE DATABASE bibliotheque_db;

USE bibliotheque_db;

CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    annee_publication INT,
    categorie VARCHAR(50),
    image VARCHAR(50)
);