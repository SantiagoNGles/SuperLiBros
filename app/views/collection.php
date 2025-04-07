<?php

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour voir votre collection.</p>";
    include_once ROOT_PATH . 'app/views/footer.php';
    exit();
}

// Traitement de l'ajout à la collection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_collection'])) {
    $gameId = $_POST['game_id'];
    $platformId = $_POST['platform_id'];
    $userRating = $_POST['user_rating'];

    if (addToCollection($_SESSION['user_id'], $gameId, $platformId, $userRating)) {
        $_SESSION['message'] = "Jeu ajouté à votre collection avec succès !";
        header("Location: " . BASE_URL . "?action=mycollection");
        exit();
    }
}

// Récupérer la liste des jeux disponibles
$conn = connexionPDO();
$stmt = $conn->query("SELECT id, title FROM games ORDER BY title");
$games = $stmt->fetchAll();

// Récupérer la collection de l'utilisateur
$userCollection = getUserCollection($_SESSION['user_id']);
?>

<h2>Ma Collection de Jeux</h2>

<!-- Formulaire d'ajout de jeu -->
<div class="add-game-form">
    <h3>Ajouter un jeu à ma collection</h3>
    <form method="post" action="">
        <div class="form-group">
            <label for="game_id">Sélectionner un jeu :</label>
            <select name="game_id" id="game_id" required onchange="updatePlatforms(this.value)">
                <option value="">Choisissez un jeu</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?php echo $game['id']; ?>"><?php echo htmlspecialchars($game['title']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="platform_id">Plateforme :</label>
            <select name="platform_id" id="platform_id" required disabled>
                <option value="">Sélectionnez d'abord un jeu</option>
            </select>
        </div>

        <div class="form-group">
            <label>Note :</label>
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <input type="radio" name="user_rating" value="<?php echo $i; ?>" id="rating-<?php echo $i; ?>" required>
                    <label for="rating-<?php echo $i; ?>">★</label>
                <?php endfor; ?>
            </div>
        </div>



        <button type="submit" name="add_to_collection">Ajouter à ma collection</button>
    </form>
</div>

<!-- Tableau de la collection -->
<?php if (!empty($userCollection)): ?>
    <table class="collection-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Développeur</th>
                <th>Date de sortie</th>
                <th>Plateforme</th>
                <th>Note</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userCollection as $item): ?>
                <tr>
                    <td><img src="<?php echo BASE_URL . $item['image_url']; ?>"
                            alt="<?php echo htmlspecialchars($item['title']); ?>" class="game-thumbnail"></td>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo htmlspecialchars($item['developer']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item['release_date'])); ?></td>
                    <td><?php echo htmlspecialchars($item['platform_name']); ?></td>
                    <td>
                        <?php
                        for ($i = 1; $i <= $item['user_rating']; $i++) {
                            echo '★';
                        }
                        for ($i = $item['user_rating'] + 1; $i <= 5; $i++) {
                            echo '☆';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Votre collection est vide. Ajoutez des jeux !</p>
<?php endif; ?>

<!-- Script pour mettre à jour dynamiquement les plateformes -->
<script>
    function updatePlatforms(gameId) {
        const platformSelect = document.getElementById('platform_id');

        // Réinitialiser le sélecteur de plateforme
        platformSelect.innerHTML = '<option value="">Chargement...</option>';
        platformSelect.disabled = true;

        // Log pour déboguer
        console.log('Fetching platforms for game ID:', gameId);
        console.log('Fetch URL:', '<?php echo BASE_URL; ?>?action=getGamePlatforms&game_id=' + gameId);

        // Correction de l'URL de requête
        fetch('<?php echo BASE_URL; ?>?action=getGamePlatforms&game_id=' + gameId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(platforms => {
                console.log('Platforms received:', platforms);  // Log des plateformes reçues

                platformSelect.innerHTML = '<option value="">Sélectionnez une plateforme</option>';
                platforms.forEach(platform => {
                    const option = document.createElement('option');
                    option.value = platform.id;
                    option.textContent = platform.name;
                    platformSelect.appendChild(option);
                });
                platformSelect.disabled = false;
            })
            .catch(error => {
                console.error('Erreur:', error);
                platformSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                platformSelect.disabled = false;
            });
    }
</script>