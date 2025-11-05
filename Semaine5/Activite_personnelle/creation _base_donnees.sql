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

INSERT INTO livres (titre, auteur, annee_publication, categorie, image) VALUES
('Vingt mille lieues sous les mers', 'Jules Verne', 1869, 'Science-fiction', 'vingt_mille_lieues.jpg'),
('Dune', 'Frank Herbert', 1965, 'Science-fiction', 'dune.jpg'),
('le petit prince', 'Frank Herbert', 1965, 'Science-fiction', 'Activite_personnelle\images\le_petit_prince.jpg'),
('Fondation', 'Isaac Asimov', 1951, 'Science-fiction', 'fondation.jpg'),
('Les Trois Mousquetaires', 'Alexandre Dumas', 1844, 'Romans historiques', 'trois_mousquetaires.jpg'),
('1984', 'George Orwell', 1949, 'Dystopie', 'Activite_personnelle\images\1984.jpg'),
('Harry Potter à l école des sorciers', 'J.K. Rowling', 2001, 'Fantasy', 'Activite_personnelle\images\harry_potter.jpg');