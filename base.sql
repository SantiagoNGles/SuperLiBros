DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS collections;
DROP TABLE IF EXISTS game_platforms;
DROP TABLE IF EXISTS platforms;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS users;

-- Création de la table "users" (utilisateurs)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table "games" (jeux vidéo)
CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    developer VARCHAR(100),
    release_date DATE,
    image_url VARCHAR(255),
    genre VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS platforms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    manufacturer VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS game_platforms (
    game_id INT,
    platform_id INT,
    PRIMARY KEY (game_id, platform_id),
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (platform_id) REFERENCES platforms(id) ON DELETE CASCADE
);

-- Création de la table "collections" (jeux dans la collection d'un utilisateur)
CREATE TABLE IF NOT EXISTS collections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_id INT,
    platform_id INT,
    user_rating INT CHECK (user_rating >= 1 AND user_rating <= 5),
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (platform_id) REFERENCES platforms(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, game_id) -- Un utilisateur ne peut ajouter un jeu qu'une seule fois
);

-- Création de la table "reviews" (avis sur les jeux)
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_id INT,
    comment TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    publish_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, game_id) -- Pour assurer la relation 1,1 -> 1,N (un utilisateur ne peut avoir qu"un avis par jeu)
);

-- Création de la table "favorites" (jeux favoris d"un utilisateur) - relation N,M
CREATE TABLE IF NOT EXISTS favorites (
    user_id INT,
    game_id INT,
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, game_id), -- Clé composite pour la relation N,M
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

-- Insertion de données d"exemple dans "users"
INSERT INTO users (username, email, password) VALUES
("john_doe", "john@doe.com", "$2y$10$CkPjkmpe9V5Ug5s6TtsWkOZq7XjTLB9U5ry.BhnA9cI2F5Khcz5t6"),
("Santiagoat", "sntg@goat.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("TheFreshMonster", "fresh@monster.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("Narvalito", "narv@lito.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("MacYannito", "mac@yannito.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("SWITZ", "switz@gmail.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("Hinqo", "hinqo@gmail.com", "$2y$10$Y4elseBeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("Nabdar", "nabdar@gmail.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y"),
("JeF*Nezeuko", "jef@nezeuko.com", "$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y");

INSERT INTO platforms (name, manufacturer) VALUES
('PS1', 'Sony'),
('PS2', 'Sony'),
('PS3', 'Sony'),
('PS4', 'Sony'),
('PS5', 'Sony'),
('Xbox 360', 'Microsoft'),
('Xbox One', 'Microsoft'),
('Xbox Series X/S', 'Microsoft'),
('NES', 'Nintendo'),
('Nintendo 64', 'Nintendo'),
('Wii U', 'Nintendo'),
('Nintendo Switch', 'Nintendo'),
('PC', 'N/A');

-- Insertion de données d"exemple dans "games"
INSERT INTO games (title, developer, release_date, image_url, genre, description) VALUES
("Super Mario Bros.", "Nintendo", "1985-07-01", "img/smb.jpg", "Platformer", "Le grand classique du jeu vidéo où Mario doit sauver la Princesse Peach."),
("Super Mario 64", "Nintendo", "2001-07-01", "img/sm64.jpg", "Platformer", "Un jeu d'aventure où Mario doit sauver la Princesse Peach."),
("Super Mario Odyssey", "Nintendo", "2017-10-27", "img/smo.jpg", "Platformer", "Super Mario Odyssey est un jeu de plates-formes en 3D sorti le 27 octobre 2017 sur Nintendo Switch. Mario, accompagné de son compagnon Cappy, voyage à travers différents royaumes pour empêcher Bowser d'épouser la Princesse Peach."),
("The Legend of Zelda: Breath of the Wild", "Nintendo", "2017-03-03", "img/zbotw.jpg", "Action-Adventure", "The Legend of Zelda: Breath of the Wild est un jeu d'action-aventure en monde ouvert sorti le 3 mars 2017 sur Nintendo Switch et Wii U. Incarnez Link et explorez librement Hyrule pour vaincre le maléfique Ganon et restaurer la paix au royaume."),
("Undertale", "Toby Fox", "2015-09-15", "img/undertale.jpg", "RPG", "Un RPG où vos choix influencent l'histoire, avec des combats uniques et une narration captivante."),
("Detroit: Become Human", "Quantic Dream", "2018-05-25", "img/detroit.jpg", "Interactive Drama", "Dans un futur proche, suivez l'histoire de trois androïdes et explorez les dilemmes moraux liés à l'intelligence artificielle."),
("Fortnite", "Epic Games", "2017-07-25", "img/fortnite.jpg", "Battle Royale", "Un jeu de battle royale où 100 joueurs s'affrontent pour être le dernier survivant sur une île en constante évolution."),
("Overwatch", "Blizzard Entertainment", "2016-05-24", "img/ow.jpg", "First-Person Shooter", "Un jeu de tir en équipe mettant en scène des héros aux capacités uniques dans des affrontements dynamiques."),
("Brawlhalla", "Blue Mammoth Games", "2017-10-17", "img/brawlhalla.jpg", "Fighting", "Un jeu de combat en 2D gratuit où des légendes s'affrontent dans des arènes variées."),
("Valorant", "Riot Games", "2020-06-02", "img/valorant.jpg", "Tactical Shooter", "Un jeu de tir tactique en 5v5 combinant des mécaniques précises et des compétences uniques par agent."),
("Broforce", "Free Lives", "2015-10-15", "img/broforce.jpg", "Platformer", "Un jeu d'action en pixel art où vous incarnez des parodies de héros d'action pour libérer le monde du mal."),
("Roblox", "Roblox Corporation", "2006-09-01", "img/roblox.jpg", "Sandbox", "Une plateforme en ligne permettant aux utilisateurs de créer et de partager leurs propres jeux et expériences."),
("Papers, Please", "Lucas Pope", "2013-08-08", "img/papersplease.jpg", "Simulation", "Incarnez un inspecteur de l'immigration dans un pays fictif et prenez des décisions morales difficiles."),
("Rocket League", "Psyonix", "2015-07-07", "img/rocketleague.jpg", "Sports", "Un mélange de football et de courses automobiles où des voitures propulsées par des fusées s'affrontent pour marquer des buts."),
("MultiVersus", "Player First Games", "2022-07-19", "img/multiversus.jpg", "Fighting", "Un jeu de combat crossover mettant en scène des personnages emblématiques de diverses franchises."),
("Crab Game", "Dani", "2021-10-29", "img/crabgame.jpg", "Multiplayer Party", "Un jeu multijoueur inspiré de jeux télévisés, où les joueurs s'affrontent dans diverses épreuves pour gagner."),
("Marvel Rivals", "NetEase Games", "2025-03-24", "img/marvelrivals.jpg", "Action", "Un jeu d'action mettant en scène des héros et des vilains de l'univers Marvel dans des affrontements épiques."),
("Minecraft", "Mojang", "2011-11-18", "img/minecraft.jpg", "Survival", "Un jeu de construction et d'aventure en monde ouvert composé de blocs, offrant une liberté créative sans limites."),
("Assassin's Creed", "Ubisoft", "2007-11-13", "img/ac1.jpg", "Action-Adventure", "Incarnez un assassin dans diverses périodes historiques et découvrez des conspirations secrètes."),
("Assassin's Creed II", "Ubisoft", "2009-11-17", "img/ac2.jpg", "Action-Adventure", "Suivez l'histoire d'Ezio Auditore da Firenze dans la Renaissance italienne."),
("Assassin's Creed Brotherhood", "Ubisoft", "2010-11-16", "img/acb.jpg", "Action-Adventure", "Continuez l'aventure d'Ezio en recrutant et en dirigeant une confrérie d'assassins à Rome."),
("Assassin's Creed Revelations", "Ubisoft", "2011-11-15", "img/acr.jpg", "Action-Adventure", "Ezio voyage à Constantinople pour découvrir les secrets d'Altaïr et de la confrérie."),
("Assassin's Creed III", "Ubisoft", "2012-10-30", "img/ac3.jpg", "Action-Adventure", "Participez à la Révolution américaine en incarnant Connor Kenway, un assassin d'origine mohawk."),
("Assassin's Creed IV: Black Flag", "Ubisoft", "2013-10-29", "img/ac4.jpg", "Action-Adventure", "Explorez les Caraïbes en tant que pirate et assassin Edward Kenway."),
("Assassin's Creed Unity", "Ubisoft", "2014-11-11", "img/acu.jpg", "Action-Adventure", "Vivez la Révolution française à travers les yeux d'Arno Dorian, un assassin en quête de rédemption."),
("Assassin's Creed Syndicate", "Ubisoft", "2015-10-23", "img/acs.jpg", "Action-Adventure", "Incarnez les jumeaux Jacob et Evie Frye dans le Londres victorien pour libérer la ville de l'oppression."),
("Assassin's Creed Origins", "Ubisoft", "2017-10-27", "img/acor.jpg", "Action-Adventure", "Découvrez les origines de la confrérie des assassins dans l'Égypte antique en incarnant Bayek."),
("Assassin's Creed Odyssey", "Ubisoft", "2018-10-05", "img/acod.jpg", "Action-Adventure", "Partez à l'aventure en Grèce antique en tant que mercenaire et découvrez votre destinée."),
("Assassin's Creed Valhalla", "Ubisoft", "2020-11-10", "img/acv.jpg", "Action-Adventure", "Incarnez Eivor, un Viking, et menez des raids pour établir une nouvelle colonie en Angleterre."),
("God of War", "Santa Monica Studio", "2005-03-22", "img/gow1.jpg", "Action-Adventure", "Suivez Kratos dans sa quête de vengeance contre les dieux de l'Olympe."),
("God of War II", "Santa Monica Studio", "2007-03-13", "img/gow2.jpg", "Action-Adventure", "Poursuivez l'épopée de Kratos alors qu'il défie le destin et les dieux"),
("God of War III", "Santa Monica Studio", "2010-03-16", "img/gow3.jpg", "Action-Adventure", "Kratos atteint le sommet de l'Olympe pour se venger des dieux."),
("God of War (2018)", "Santa Monica Studio", "2018-04-20", "img/gow2018.jpg", "Action-Adventure", "Kratos et son fils Atreus partent en quête dans un monde inspiré de la mythologie nordique."),
("God of War: Ragnarök", "Santa Monica Studio", "2022-11-09", "img/gowr.jpg", "Action-Adventure", "Kratos et Atreus affrontent les dieux nordiques alors que le Ragnarök approche."),
("Uncharted: Drake's Fortune", "Naughty Dog", "2007-11-19", "img/uncharted1.jpg", "Action-Adventure", "Nathan Drake part à la recherche d'El Dorado dans une aventure pleine d'action."),
("Uncharted 2: Among Thieves", "Naughty Dog", "2009-10-13", "img/uncharted2.jpg", "Action-Adventure", "Nathan Drake explore l'Himalaya pour retrouver la légendaire cité de Shambhala."),
("Uncharted 3: Drake's Deception", "Naughty Dog", "2011-11-01", "img/uncharted3.jpg", "Action-Adventure", "Drake recherche la cité perdue d'Ubar, traversant déserts et intrigues."),
("Uncharted 4: A Thief's End", "Naughty Dog", "2016-05-10", "img/uncharted4.jpg", "Action-Adventure", "Nathan Drake se lance dans une dernière aventure à la recherche du trésor du pirate Henry Avery."),
("Grand Theft Auto III", "Rockstar Games", "2001-10-22", "img/gta3.jpg", "Action", "Plongez dans le crime organisé de Liberty City avec une liberté sans précédent."),
("Grand Theft Auto IV", "Rockstar Games", "2008-04-29", "img/gta4.jpg", "Action", "Niko Bellic arrive en Amérique à la recherche du rêve américain et se retrouve plongé dans le crime."),
("Grand Theft Auto V", "Rockstar Games", "2013-09-17", "img/gta5.jpg", "Action", "Suivez les aventures de Michael, Franklin et Trevor dans une immense ville ouverte et immersive."),
("Call of Duty", "Infinity Ward", "2003-10-29", "img/cod1.jpg", "FPS", "Un FPS basé sur la Seconde Guerre mondiale mettant en avant le combat en équipe."),
("Call of Duty 2", "Infinity Ward", "2005-10-25", "img/cod2.jpg", "FPS", "Revivez les batailles historiques de la Seconde Guerre mondiale avec une intensité accrue."),
("Call of Duty 3", "Treyarch", "2006-11-07", "img/cod3.jpg", "FPS", "Revivez la Seconde Guerre mondiale à travers les yeux de soldats alliés dans une campagne intense et immersive."),
("Call of Duty 4: Modern Warfare", "Infinity Ward", "2007-11-05", "img/codmw1.jpg", "FPS", "Un FPS moderne révolutionnaire mettant en scène des missions intenses contre le terrorisme."),
("Call of Duty: Modern Warfare 2", "Infinity Ward", "2009-11-10", "img/codmw2.jpg", "FPS", "Une campagne palpitante et un multijoueur iconique dans un contexte de guerre moderne."),
("Call of Duty: Black Ops", "Treyarch", "2010-11-09", "img/codbo.jpg", "FPS", "Explorez la guerre froide à travers des missions d'espionnage et d'action effrénée."),
("Call of Duty: Black Ops II", "Treyarch", "2012-11-12", "img/codbo2.jpg", "FPS", "Un scénario futuriste avec des choix impactant l'histoire et un multijoueur compétitif."),
("Call of Duty: Black Ops III", "Treyarch", "2015-11-06", "img/codbo3.jpg", "FPS", "Un jeu de tir futuriste avec une campagne solo axée sur des technologies avancées et des soldats augmentés, ainsi qu'un mode multijoueur innovant."),
("Call of Duty: Black Ops IV", "Treyarch", "2018-10-12", "img/codbo4.jpg", "FPS", "Un jeu axé sur le multijoueur, sans campagne solo, avec un mode battle royale intitulé 'Blackout' et des batailles en ligne intenses."),
("Crash Bandicoot", "Naughty Dog", "1996-09-09", "img/crash1.jpg", "Platformer", "Un jeu de plateforme emblématique où Crash affronte le Dr. Neo Cortex."),
("Crash Bandicoot 2: Cortex Strikes Back", "Naughty Dog", "1997-11-05", "img/crash2.jpg", "Platformer",  "Crash revient pour affronter une nouvelle fois Cortex et ses plans diaboliques."),
("Crash Bandicoot 3: Warped", "Naughty Dog", "1998-10-31", "img/crash3.jpg", "Platformer", "Voyagez à travers le temps pour empêcher Cortex et Uka Uka de dominer le monde."),
("Crash Bandicoot 4: It's About Time", "Toys for Bob", "2020-10-02", "img/crash4.jpg", "Platformer", "Crash et Coco voyagent à travers différentes dimensions pour sauver le multivers."); 

-- Insertions des plateformes pour chaque jeu
INSERT INTO game_platforms (game_id, platform_id) VALUES
-- Super Mario Bros.
(1, 9),  -- NES

-- Super Mario 64
(2, 10),  -- Nintendo 64

-- Super Mario Odyssey
(3, 11),  -- Nintendo Switch

-- The Legend of Zelda: Breath of the Wild
(4, 11),  -- Wii U
(4, 12),  -- Nintendo Switch

-- Undertale
(5, 4),
(5, 5),
(5, 7),
(5, 8),
(5, 11),  -- Nintendo Switch
(5, 12),  -- PC

-- Detroit: Become Human
(6, 4),   -- PS4
(6, 5),   -- PS5

-- Fortnite
(7, 12),  -- PC
(7, 4),   -- PS4
(7, 5),   -- PS5
(7, 7),   -- Xbox One
(7, 8),   -- Xbox Series X/S
(7, 11),  -- Nintendo Switch

-- Overwatch
(8, 12),  -- PC
(8, 4),   -- PS4
(8, 5),   -- PS5
(8, 7),   -- Xbox One
(8, 8),   -- Xbox Series X/S

-- Brawlhalla
(9, 12),  -- PC
(9, 4),   -- PS4
(9, 5),   -- PS5
(9, 7),   -- Xbox One
(9, 8),   -- Xbox Series X/S
(9, 11),  -- Nintendo Switch

-- Valorant
(10, 12), -- PC

-- Broforce
(11, 12), -- PC
(11, 11), -- Nintendo Switch
(11, 4),  -- PS4

-- Roblox
(12, 12), -- PC
(12, 4),  -- PS4
(12, 7),  -- Xbox One
(12, 11), -- Nintendo Switch

-- Papers, Please
(13, 12), -- PC

-- Rocket League
(14, 12), -- PC
(14, 4),  -- PS4
(14, 5),  -- PS5
(14, 7),  -- Xbox One
(14, 8),  -- Xbox Series X/S
(14, 11), -- Nintendo Switch

-- MultiVersus
(15, 12), -- PC
(15, 4),  -- PS4
(15, 5),  -- PS5
(15, 7),  -- Xbox One
(15, 8),  -- Xbox Series X/S

-- Crab Game
(16, 12), -- PC

-- Marvel Rivals
(17, 12), -- PC
(17, 4),  -- PS4
(17, 5),  -- PS5
(17, 7),  -- Xbox One
(17, 8),  -- Xbox Series X/S

-- Minecraft
(18, 12), -- PC
(18, 4),  -- PS4
(18, 5),  -- PS5
(18, 7),  -- Xbox One
(18, 8),  -- Xbox Series X/S
(18, 11), -- Nintendo Switch

-- Assassin's Creed Series
(19, 3),  -- PS3
(19, 6),  -- Xbox 360
(19, 12), -- PC

(20, 3),  -- PS3
(20, 6),  -- Xbox 360
(20, 12), -- PC

(21, 3),  -- PS3
(21, 6),  -- Xbox 360
(21, 12), -- PC

(22, 3),  -- PS3
(22, 6),  -- Xbox 360
(22, 12), -- PC

(23, 3),  -- PS3
(23, 6),  -- Xbox 360
(23, 12), -- PC

(24, 4),  -- PS4
(24, 12), -- PC

(25, 4),  -- PS4
(25, 12), -- PC

(26, 4),  -- PS4
(26, 5),  -- PS5
(26, 12), -- PC

(27, 4),  -- PS4
(27, 5),  -- PS5
(27, 12), -- PC

(28, 4),  -- PS4
(28, 5),  -- PS5
(28, 12), -- PC

-- God of War Series
(29, 3),  -- PS3
(30, 3),  -- PS3
(31, 3),  -- PS3
(32, 4),  -- PS4
(33, 5),  -- PS5

-- Uncharted Series
(34, 3),  -- PS3
(35, 3),  -- PS3
(36, 3),  -- PS3
(37, 4),  -- PS4

-- Grand Theft Auto Series
(38, 6),  -- Xbox 360
(39, 3),  -- PS3
(39, 6),  -- Xbox 360
(39, 12), -- PC
(40, 4),  -- PS4
(40, 5),  -- PS5
(40, 7),  -- Xbox One
(40, 12), -- PC

-- Call of Duty Series
(41, 6),  -- Xbox 360
(42, 6),  -- Xbox 360
(43, 6),  -- Xbox 360
(44, 6),  -- Xbox 360
(45, 3),  -- PS3
(45, 6),  -- Xbox 360
(45, 12), -- PC
(46, 3),  -- PS3
(46, 6),  -- Xbox 360
(46, 12), -- PC
(47, 3),  -- PS3
(47, 6),  -- Xbox 360
(47, 12), -- PC
(48, 3),  -- PS3
(48, 6),  -- Xbox 360
(48, 12), -- PC
(49, 4),  -- PS4
(49, 7),  -- Xbox One
(49, 12), -- PC

-- Crash Bandicoot Series
(50, 12), -- PC
(51, 12), -- PC
(52, 12), -- PC
(53, 4),  -- PS4
(53, 5),  -- PS5
(53, 7),  -- Xbox One
(53, 11); -- Nintendo Switch

-- Insertion de données d"exemple dans "reviews"
INSERT INTO reviews (user_id, game_id, comment, rating) VALUES
(1, 1, "Un jeu absolument incroyable! L'exploration et les puzzles sont exceptionnels.", 5),
(2, 2, "Le meilleur jeu de tous les temps. Voilà.", 5),
(9, 2, "Le meilleur jeu de tous les temps. Je suis d'accord avec TheFreshMonster.", 5);


-- Insertion de données d"exemple dans "favorites"
INSERT INTO favorites (user_id, game_id) VALUES
(1, 3),
(1, 4),
(2, 2),
(9, 2);