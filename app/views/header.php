<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'SuperLiBros - Votre bibliothèque de jeux vidéo'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?php echo BASE_URL; ?>?action=home">
                    <h1>SuperLiBros</h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>?action=home">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?action=games">Jeux</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>?action=favorites">Mes favoris</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?action=myReviews">Mes avis</a></li>
                        <li>
                            <div class="dropdown">
                                <button class="dropbtn"><?php echo htmlspecialchars($_SESSION['username']); ?></button>
                                <div class="dropdown-content">
                                    <a href="<?php echo BASE_URL; ?>?action=profile">Mon profil</a>
                                    <a href="<?php echo BASE_URL; ?>?action=logout">Déconnexion</a>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>?action=login">Connexion</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?action=register">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>