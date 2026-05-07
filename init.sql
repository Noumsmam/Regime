DROP DATABASE IF EXISTS Regime;
CREATE DATABASE Regime;
USE Regime;

CREATE TABLE genre(
    id INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_genre INT NOT NULL,
    FOREIGN KEY (id_genre) REFERENCES genre(id)
);

CREATE TABLE userInfo (
    id_user INT NOT NULL,
    taille FLOAT NOT NULL,
    poids FLOAT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) 
);

CREATE TABLE Objectif(
    id INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);

CREATE TABLE userObjectif(
    id_user INT NOT NULL,
    id_objectif INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_objectif) REFERENCES Objectif(id)
);

CREATE TABLE porteMonnaie(
    id INT PRIMARY KEY 
    id_user INT NOT NULL UNIQUE,
    montant INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE offre(
    id INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50),
    remise FLOAT
);

CREATE TABLE userOffre(
    id_user INT NOT NULL,
    id_offre INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_offre) REFERENCES offre(id)
);

CREATE TABLE sport(
    id INT PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50)
);


CREATE TABLE userRegime(
    id_user INT NOT NULL,
    id_regime INT NOT NULL,
    id_sport INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_regime) REFERENCES regime(id),
    FOREIGN KEY (id_sport) REFERENCES sport(id),

);

-- Régimes
CREATE TABLE regimes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    calories_per_day INT UNSIGNED NOT NULL,
    description TEXT,
    difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Activités
CREATE TABLE activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    calories_burn_per_hour INT UNSIGNED NOT NULL,
    intensity ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Plans (lien goal → régime + activité)
CREATE TABLE user_goals_plan (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    goal_id INT UNSIGNED NOT NULL,
    regime_id INT UNSIGNED NOT NULL,
    activity_id INT UNSIGNED NOT NULL,
    minutes_per_day INT UNSIGNED DEFAULT 30,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    KEY goal_id (goal_id),
    KEY regime_id (regime_id),
    KEY activity_id (activity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


