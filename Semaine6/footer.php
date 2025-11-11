	<style>
	    .nav-link {
            display: ;
            list-style: none;
        }
        
        .nav-link li {
            margin-left: 1.5rem;
        }
        
        .nav-link a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-link a:hover {
            color: var(--secondary-color);
        }
	 footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .footer-section {
            flex: 1;
            min-width: 250px;
            margin-bottom: 1.5rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 0.5rem;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 1.5rem;
        }
        
	</style>
	<footer>
	<div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>À propos</h3>
                    <p>Notre bibliothèque en ligne offre un accès à des milliers de livres pour tous les goûts et tous 		les âges.</p>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
		<nav>
                    <ul class="nav-link">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="wishlist.php">Ma liste de lecture</a></li>
                        <li><a href="add_book.php">Ajouter un livre</a></li>
                    </ul>
		</nav>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: romainakpo86@gmail.com</p>
                    <p>Téléphone: (+229) 01 9765 3335/01 9459 2567</p>
                    <p>Adresse: Rue Temple du Son Abomey-Calavi, Bénin</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Bibliothèque en Ligne. Tous droits réservés.</p>
            </div>
        </div>
	</footer>