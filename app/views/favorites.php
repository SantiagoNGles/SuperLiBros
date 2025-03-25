<section class="favorites-list">
    <h2>Mes Jeux Favoris</h2>

    <?php if (empty($favoriteGames)): ?>
        <p>Vous n'avez pas encore de jeux favoris. Découvrez et ajoutez des jeux à vos favoris !</p>
        <a href="<?php echo BASE_URL; ?>?action=games" class="btn">Voir tous les jeux</a>
    <?php else: ?>
        <div class="games-grid">
            <?php foreach ($favoriteGames as $game): ?>
                <div class="game-card">
                    <img src="<?php echo BASE_URL . htmlspecialchars($game['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($game['title']); ?>">
                    <div class="game-info">
                        <h3><?php echo htmlspecialchars($game['title']); ?></h3>
                        <p>Développeur : <?php echo htmlspecialchars($game['developer']); ?></p>
                        <p>Date de sortie : <?php echo date('d/m/Y', strtotime($game['release_date'])); ?></p>

                        <form method="POST" action="<?php echo BASE_URL; ?>?action=favorites">
                            <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                            <button type="submit" name="remove_favorite" class="btn btn-remove">
                                Retirer des favoris
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>