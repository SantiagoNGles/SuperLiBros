</main>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>À propos de SuperLiBros</h3>
                <p>Votre bibliothèque de jeux vidéo en ligne pour découvrir, évaluer et partager votre passion pour les
                    jeux.</p>
            </div>

            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>?action=home">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?action=games">Jeux</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>?action=mycollection">Ma collection</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?action=favorites">Mes favoris</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?action=myReviews">Mes avis</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>?action=login">Connexion</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?action=register">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact</h3>
                <p>Vous avez des questions ou des suggestions ?</p>
                <p>Contactez-nous à <a href="mailto:contact@superlibros.fr">contact@superlibros.fr</a></p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> SuperLiBros - Tous droits réservés</p>
        </div>
    </div>
</footer>

</body>

</html>