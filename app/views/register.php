<h2>Inscription</h2>

<form action="<?php echo BASE_URL; ?>?action=registerProcess" method="post" novalidate>
    <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['form_data']['username'] ?? ''); ?>" required aria-required="true">
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['form_data']['email'] ?? ''); ?>" required aria-required="true">
    </div>
    
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required aria-required="true" minlength="6">
        <small>Le mot de passe doit contenir au moins 6 caractères.</small>
    </div>
    
    <div class="form-group">
        <label for="confirm_password">Confirmez le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password" required aria-required="true">
    </div>
    
    <button type="submit">S'inscrire</button>
</form>

<p>Déjà inscrit ? <a href="<?php echo BASE_URL; ?>?action=login">Connectez-vous</a></p>

<?php 
// Nettoyage des données du formulaire après affichage
unset($_SESSION['form_data']);

require_once ROOT_PATH . '/app/views/footer.php'; 
?>