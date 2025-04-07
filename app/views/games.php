<section class="games-list">
    <h2>Liste des Jeux</h2>
    
    <?php if (empty($games)): ?>
        <p>Aucun jeu n'est disponible pour le moment.</p>
    <?php else: ?>
        <div class="games-grid">
            <?php foreach ($games as $game): ?>
                <div class="game-card">
                    <img src="<?php echo BASE_URL . htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                    <div class="game-info">
                        <h3><?php echo htmlspecialchars($game['title']); ?></h3>
                        <p>Développeur : <?php echo htmlspecialchars($game['developer']); ?></p>
                        <p>Date de sortie : <?php echo date('d/m/Y', strtotime($game['release_date'])); ?></p>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="<?php echo BASE_URL; ?>?action=games">
                                <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                <button type="submit" name="add_favorite" class="btn-favorite">
                                    Ajouter aux favoris
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>