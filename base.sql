DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS libraries;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS users;

-- Création de la table 'users' (utilisateurs)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table 'games' (jeux vidéo)
CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    developer VARCHAR(100),
    release_date DATE,
    image_url VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table 'reviews' (avis sur les jeux)
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_id INT,
    comment TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    publish_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, game_id) -- Pour assurer la relation 1,1 -> 1,N (un utilisateur ne peut avoir qu'un avis par jeu)
);

-- Création de la table 'favorites' (jeux favoris d'un utilisateur) - relation N,M
CREATE TABLE IF NOT EXISTS favorites (
    user_id INT,
    game_id INT,
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, game_id), -- Clé composite pour la relation N,M
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

-- Insertion de données d'exemple dans 'users'
INSERT INTO users (username, email, password) VALUES
('john_doe', 'john@example.com', '$2y$10$CkPjkmpe9V5Ug5s6TtsWkOZq7XjTLB9U5ry.BhnA9cI2F5Khcz5t6'),  -- password : 'password123'
('admin_user', 'admin@example.com', '$2y$10$Y4.vl9BeAodPZopzPfVnWOIaaO2fZ9eqlyqMw0v6m/Z8X56P9sE1y');  -- password : 'admin123'

-- Insertion de données d'exemple dans 'games'
INSERT INTO games (title, developer, release_date, image_url, description) VALUES
('The Legend of Zelda: Breath of the Wild', 'Nintendo', '2017-03-03', 'images/zelda.jpg', "Un jeu d'aventure en monde ouvert où Link doit sauver Hyrule."),
('Super Mario Odyssey', 'Nintendo', '2017-10-27', 'public/mario.jpg', 'Mario voyage à travers différents royaumes pour sauver la princesse Peach.'),
('Metroid Prime', 'Retro Studios', '2002-11-17', 'images/metroid.jpg', "Samus Aran explore la planète Tallon IV dans ce FPS d'aventure.");

-- Insertion de données d'exemple dans 'reviews'
INSERT INTO reviews (user_id, game_id, comment, rating) VALUES
(1, 1, "Un jeu absolument incroyable! L'exploration et les puzzles sont exceptionnels.", 5),
(2, 2, 'Un excellent platformer 3D avec des mécaniques innovantes.', 4);

-- Insertion de données d'exemple dans 'favorites'
INSERT INTO favorites (user_id, game_id) VALUES
(1, 1),
(1, 2),
(2, 3);