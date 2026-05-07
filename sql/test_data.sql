-- Test data for both schemas present in this repo
-- 1) Seed for `user` table used by UserModel/AuthController
-- Password for all accounts: "password" (bcrypt hash used)

INSERT INTO user (nom, email, password, genre, taille, poids, objectif, gold_option, portefeuille) VALUES
('Alice Dupont', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 'F', 165.00, 60.00, 'Atteindre son IMC idéal', 1, 20.00),
('Bob Martin', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 'M', 180.00, 85.00, 'Réduire son poids', 0, 5.50),
('Chloe Laurent', 'chloe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 'F', 158.00, 54.00, 'Atteindre son IMC idéal', 0, 0.00),
('Daniel Moreau', 'daniel@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 'M', 175.00, 68.00, 'Augmenter son poids', 0, 10.00),
('Emma Bernard', 'emma@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 'F', 170.00, 72.00, 'Réduire son poids', 1, 50.00);

-- 2) Seed for `init.sql` schema (tables: genre, users, userInfo, Objectif, userObjectif, porteMonnaie, offre, userOffre, sport, regime, userRegime)
-- Insert genres
INSERT INTO genre (libelle) VALUES ('M'), ('F'), ('Autre');

-- Insert objectives
INSERT INTO Objectif (libelle) VALUES ('Augmenter son poids'), ('Réduire son poids'), ('Atteindre son IMC idéal');

-- Insert sports
INSERT INTO sport (libelle) VALUES ('Course'), ('Natation'), ('Musculation'), ('Cyclisme'), ('Yoga');

-- Insert offres
INSERT INTO offre (libelle, remise) VALUES ('Gold', 15.0), ('Silver', 5.0);

-- Insert users (for init.sql schema: users.username and users.email)
-- Using same bcrypt hash for "password"
INSERT INTO users (email, username, password, id_genre) VALUES
('alice@example.com', 'alice', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 2),
('bob@example.com', 'bob', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 1),
('chloe@example.com', 'chloe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 2),
('daniel@example.com', 'daniel', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 1),
('emma@example.com', 'emma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.w7Y5sFJpBX8a4Hq.', 2);

-- Insert userInfo (taille en cm, poids en kg) — assuming user ids are 1..5
INSERT INTO userInfo (id_user, taille, poids) VALUES
(1, 165.0, 60.0),
(2, 180.0, 85.0),
(3, 158.0, 54.0),
(4, 175.0, 68.0),
(5, 170.0, 72.0);

-- Assign one objectif to each user
INSERT INTO userObjectif (id_user, id_objectif) VALUES
(1, 3),
(2, 2),
(3, 3),
(4, 1),
(5, 2);

-- Create porteMonnaie entries (id and id_user assumed incremental)
INSERT INTO porteMonnaie (id, id_user, montant) VALUES
(1, 1, 20),
(2, 2, 5.5),
(3, 3, 0),
(4, 4, 10),
(5, 5, 50);

-- Assign Gold offer to Alice and Emma
INSERT INTO userOffre (id_user, id_offre) VALUES
(1, 1),
(5, 1);

-- Insert some regimes
INSERT INTO regime (viande, poisson, volaille, duree, prix) VALUES
(30, 40, 30, 30, 70.0),
(40, 30, 30, 30, 85.0),
(0, 0, 50, 30, 60.0),
(35, 35, 30, 30, 100.0),
(20, 40, 40, 30, 50.0);

-- Assign a regime to user 2 (bob) with sport id 1 (Course) — note: userRegime schema expects three ids
INSERT INTO userRegime (id_user, id_regime, id_sport) VALUES
(2, 1, 1),
(1, 5, 2);

-- Données de test (5 régimes)
INSERT INTO regimes (name, calories_per_day, description, difficulty) VALUES
('Régime Léger - Maintien', 2000, 'Régime équilibré pour maintenir son poids avec 2000 calories par jour.', 'easy'),
('Régime Amaigrissant - Modéré', 1500, 'Régime modéré pour perdre du poids progressivement : 1500 calories par jour.', 'medium'),
('Régime Amaigrissant - Intensif', 1200, 'Régime intensif pour une perte de poids rapide : 1200 calories par jour.', 'hard'),
('Régime Gainant - Modéré', 2800, 'Régime pour prendre du poids sainement : 2800 calories par jour riche en protéines.', 'medium'),
('Régime Gainant - Intensif', 3500, 'Régime intensif pour prendre du poids rapidement : 3500 calories par jour.', 'hard');

-- Données de test (5 activités)
INSERT INTO activities (name, calories_burn_per_hour, intensity) VALUES
('Marche rapide', 300, 'low'),
('Jogging', 600, 'medium'),
('Course à pied', 800, 'high'),
('Musculation', 500, 'medium'),
('Cardio intense (HIIT)', 900, 'high');