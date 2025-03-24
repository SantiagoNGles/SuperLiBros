<h2>Profil</h2>

<?php
if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
    unset($_SESSION['errors']);
}

if (!empty($_SESSION['message'])) {
    echo "<p style='color: green;'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}
?>

<?php if ($user): ?>
    <div id="profile-display">
        <h3>Vos informations</h3>
        <p><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($user['username']); ?>
        <br \>
           <button type="button" onclick="showEditUsername()">Modifier</button>
        </p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?> 
        <br \>
           <button type="button" onclick="showEditEmail()">Modifier</button>
        </p>
    </div>
    
    <!-- Formulaire de modification du nom d'utilisateur -->
    <div id="edit-username-form" style="display: none;">
        <h3>Modifier votre nom d'utilisateur</h3>
        <form action="<?php echo BASE_URL; ?>?action=profile&edit=username" method="post">
            <div class="form-group">
                <label for="username">Nouveau nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <button type="submit">Enregistrer</button>
            <button type="button" onclick="hideEditUsername()">Annuler</button>
        </form>
    </div>
    
    <!-- Formulaire de modification de l'email -->
    <div id="edit-email-form" style="display: none;">
        <h3>Modifier votre email</h3>
        <form action="<?php echo BASE_URL; ?>?action=profile&edit=email" method="post">
            <div class="form-group">
                <label for="email">Nouvel email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit">Enregistrer</button>
            <button type="button" onclick="hideEditEmail()">Annuler</button>
        </form>
    </div>

    <script>
        function showEditUsername() {
            document.getElementById('profile-display').style.display = 'none';
            document.getElementById('edit-username-form').style.display = 'block';
            document.getElementById('edit-email-form').style.display = 'none';
        }
        
        function hideEditUsername() {
            document.getElementById('profile-display').style.display = 'block';
            document.getElementById('edit-username-form').style.display = 'none';
        }
        
        function showEditEmail() {
            document.getElementById('profile-display').style.display = 'none';
            document.getElementById('edit-username-form').style.display = 'none';
            document.getElementById('edit-email-form').style.display = 'block';
        }
        
        function hideEditEmail() {
            document.getElementById('profile-display').style.display = 'block';
            document.getElementById('edit-email-form').style.display = 'none';
        }
    </script>
<?php else: ?>
    <p style="color: red;">Impossible de charger votre profil.</p>
<?php endif; ?>