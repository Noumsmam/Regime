-- Script SQL pour le projet Régimes Alimentaires
-- À exécuter pour initialiser la base de données

DROP DATABASE IF EXISTS regime_alimentaire;
CREATE DATABASE regime_alimentaire;
USE regime_alimentaire;

-- Table utilisateur
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    genre ENUM('M', 'F', 'Autre') NOT NULL,
    taille DECIMAL(5, 2) NOT NULL COMMENT 'Taille en cm',
    poids DECIMAL(5, 2) NOT NULL COMMENT 'Poids en kg',
    objectif VARCHAR(100) COMMENT 'Augmenter poids, Réduire poids, Atteindre IMC idéal',
    gold_option BOOLEAN DEFAULT 0 COMMENT '0=Non, 1=Oui',
    portefeuille DECIMAL(10, 2) DEFAULT 0 COMMENT 'Solde en euros',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table régime
CREATE TABLE regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    pourcentage_viande INT NOT NULL COMMENT '% de viande',
    pourcentage_poisson INT NOT NULL COMMENT '% de poisson',
    pourcentage_volaille INT NOT NULL COMMENT '% de volaille',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table prix régime (varient selon la durée)
CREATE TABLE regime_prix (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    duree_jours INT NOT NULL COMMENT 'Durée en jours',
    prix DECIMAL(10, 2) NOT NULL,
    variation_poids DECIMAL(5, 2) COMMENT 'Perte/gain de poids estimé en kg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (regime_id) REFERENCES regime(id) ON DELETE CASCADE,
    UNIQUE KEY unique_regime_duree (regime_id, duree_jours)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table activité sportive
CREATE TABLE activite_sportive (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    calories_brulees_par_heure INT COMMENT 'Calories brûlées/heure, approximation',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table codes portefeuille
CREATE TABLE code_portefeuille (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    montant DECIMAL(10, 2) NOT NULL COMMENT 'Montant en euros',
    utilisee BOOLEAN DEFAULT 0,
    user_id INT,
    date_utilisation TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL,
    INDEX idx_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table paramètres système
CREATE TABLE parametre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour suivre les régimes des utilisateurs
CREATE TABLE user_regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    regime_prix_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('En cours', 'Terminé', 'Annulé') DEFAULT 'En cours',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (regime_prix_id) REFERENCES regime_prix(id) ON DELETE RESTRICT,
    INDEX idx_user_id (user_id),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données de test
INSERT INTO regime (nom, description, pourcentage_viande, pourcentage_poisson, pourcentage_volaille) VALUES
('Régime Méditerranéen', 'Riche en poisson et fruits de mer', 20, 40, 40),
('Régime Protéine', 'Augmente la masse musculaire', 40, 30, 30),
('Régime Végétalien', 'Sans viande ni poisson', 0, 0, 50),
('Régime Équilibré', 'Pour maintenir son poids', 30, 25, 45),
('Régime Cétogène', 'Faible en glucides', 35, 35, 30);

INSERT INTO activite_sportive (nom, description, calories_brulees_par_heure) VALUES
('Courses à pied', 'Jogging ou course rapide', 600),
('Musculation', 'Entraînement en salle', 400),
('Natation', 'Nage libre', 500),
('Cyclisme', 'Vélo ou vélo d\'appartement', 450),
('Yoga', 'Étirement et méditation', 200);

INSERT INTO code_portefeuille (code, montant) VALUES
('CODE2026001', 50),
('CODE2026002', 25),
('CODE2026003', 100),
('CODE2026004', 30),
('CODE2026005', 75),
('CODE2026006', 20),
('CODE2026007', 40),
('CODE2026008', 60),
('CODE2026009', 15),
('CODE2026010', 80),
('CODE2026011', 35),
('CODE2026012', 45),
('CODE2026013', 55),
('CODE2026014', 65),
('CODE2026015', 90);

INSERT INTO regime_prix (regime_id, duree_jours, prix, variation_poids) VALUES
(1, 7, 20, -1.5),
(1, 30, 70, -6),
(1, 90, 180, -18),
(2, 7, 25, 1),
(2, 30, 85, 4),
(2, 90, 220, 12),
(3, 7, 18, -1),
(3, 30, 60, -4),
(3, 90, 150, -12),
(4, 7, 15, 0),
(4, 30, 50, 0),
(4, 90, 130, 0),
(5, 7, 30, -2),
(5, 30, 100, -8),
(5, 90, 260, -24);
