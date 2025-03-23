<h2>Connexion</h2>

<form action="<?php echo BASE_URL; ?>?action=loginProcess" method="post" novalidate>
    <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['form_data']['username'] ?? ''); ?>" required aria-required="true">
    </div>
    
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required aria-required="true">
    </div>
    
    <button type="submit">Se connecter</button>
</form>

<p>Pas encore inscrit ? <a href="<?php echo BASE_URL; ?>?action=register">Créez un compte</a></p>

<?php 
// Nettoyage des données du formulaire après affichage
unset($_SESSION['form_data']);

require_once ROOT_PATH . '/app/views/footer.php'; 
?>