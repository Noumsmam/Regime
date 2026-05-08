-- Données de test pour le schéma actuel de l'application
-- Mot de passe utilisé pour tous les comptes de test : "password"
-- Hachage bcrypt pour "password"
-- $2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6

INSERT INTO genre (libelle) VALUES
('M'),
('F'),
('Autre');

INSERT INTO Objectif (libelle) VALUES
('Augmenter son poids'),
('Réduire son poids'),
('Atteindre son IMC idéal');

INSERT INTO offre (libelle, remise, price, created_at, updated_at) VALUES
('Gold', 15.00, 9.99, NOW(), NOW()),
('Silver', 5.00, NULL, NOW(), NOW());

INSERT INTO sport (libelle) VALUES
('Course'),
('Natation'),
('Musculation'),
('Cyclisme'),
('Yoga');

INSERT INTO users (email, username, password, id_genre, created_at, updated_at) VALUES
('alice@example.com', 'alice', '$2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6', 2, NOW(), NOW()),
('bob@example.com', 'bob', '$2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6', 1, NOW(), NOW()),
('chloe@example.com', 'chloe', '$2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6', 2, NOW(), NOW()),
('daniel@example.com', 'daniel', '$2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6', 1, NOW(), NOW()),
('emma@example.com', 'emma', '$2y$10$z.OXV2Zyy3zEYdJ8B8UEKO0GYiQbZlCOgECs2IMH59Byw1yMX0gE6', 2, NOW(), NOW());
-- le mdp c'est password pour tous les utilisateurs

INSERT INTO userInfo (id_user, taille, poids, created_at, updated_at) VALUES
(1, 165.00, 60.00, NOW(), NOW()),
(2, 180.00, 85.00, NOW(), NOW()),
(3, 158.00, 54.00, NOW(), NOW()),
(4, 175.00, 68.00, NOW(), NOW()),
(5, 170.00, 72.00, NOW(), NOW());

INSERT INTO userObjectif (id_user, id_objectif) VALUES
(1, 3),
(2, 2),
(3, 3),
(4, 1),
(5, 2);

INSERT INTO porteMonnaie (id_user, montant, created_at, updated_at) VALUES
(1, 20.00, NOW(), NOW()),
(2, 5.50, NOW(), NOW()),
(3, 0.00, NOW(), NOW()),
(4, 10.00, NOW(), NOW()),
(5, 50.00, NOW(), NOW());

INSERT INTO userOffre (id_user, id_offre) VALUES
(1, 1),
(5, 1);

INSERT INTO userRegime (id_user, id_regime, id_sport) VALUES
(2, 1, 1),
(1, 5, 2);

INSERT INTO goals (user_id, type, target_value, duration_days, start_date, end_date, status, created_at, updated_at) VALUES
(1, 'reach_ideal', 60.00, 30, NULL, NULL, 'pending', NOW(), NOW()),
(2, 'lose', 75.00, 45, NULL, NULL, 'pending', NOW(), NOW()),
(3, 'reach_ideal', 54.00, 20, NULL, NULL, 'pending', NOW(), NOW()),
(4, 'gain', 75.00, 30, NULL, NULL, 'pending', NOW(), NOW()),
(5, 'lose', 65.00, 60, NULL, NULL, 'pending', NOW(), NOW());

INSERT INTO regimes (name, calories_per_day, description, difficulty, pourcentage_viande, pourcentage_poisson, pourcentage_volaille, price, created_at, updated_at) VALUES
('Régime Léger - Maintien', 2000, 'Régime équilibré pour maintenir son poids avec 2000 calories par jour.', 'easy', 33.00, 33.00, 34.00, 4.99, NOW(), NOW()),
('Régime Amaigrissant - Modéré', 1500, 'Régime modéré pour perdre du poids progressivement : 1500 calories par jour.', 'medium', 30.00, 35.00, 35.00, 6.99, NOW(), NOW()),
('Régime Amaigrissant - Intensif', 1200, 'Régime intensif pour une perte de poids rapide : 1200 calories par jour.', 'hard', 20.00, 40.00, 40.00, 7.99, NOW(), NOW()),
('Régime Gainant - Modéré', 2800, 'Régime pour prendre du poids sainement : 2800 calories par jour riche en protéines.', 'medium', 40.00, 30.00, 30.00, 5.99, NOW(), NOW()),
('Régime Gainant - Intensif', 3500, 'Régime intensif pour prendre du poids rapidement : 3500 calories par jour.', 'hard', 35.00, 33.00, 32.00, 8.99, NOW(), NOW());

INSERT INTO activities (name, calories_burn_per_hour, intensity, created_at, updated_at) VALUES
('Marche rapide', 300, 'low', NOW(), NOW()),
('Jogging', 600, 'medium', NOW(), NOW()),
('Course à pied', 800, 'high', NOW(), NOW()),
('Musculation', 500, 'medium', NOW(), NOW()),
('Cardio intense (HIIT)', 900, 'high', NOW(), NOW());

INSERT INTO wallets (user_id, balance, created_at, updated_at) VALUES
(1, 20.00, NOW(), NOW()),
(2, 5.50, NOW(), NOW()),
(3, 0.00, NOW(), NOW()),
(4, 10.00, NOW(), NOW()),
(5, 50.00, NOW(), NOW());

INSERT INTO coupons (code, amount, is_active, expires_at, max_uses, used_count, created_at, updated_at) VALUES
('500001', 500.00, 1, NULL, NULL, 0, NOW(), NOW()),
('500002', 1000.00, 1, NULL, NULL, 0, NOW(), NOW()),
('500003', 1500.00, 1, NULL, NULL, 0, NOW(), NOW()),
('500004', 2000.00, 1, NULL, NULL, 0, NOW(), NOW()),
('500005', 3000.00, 1, NULL, NULL, 0, NOW(), NOW());

-- Les plans d'objectifs sont créés automatiquement lorsqu'un objectif est activé.
-- Exemple d'insertion manuelle si nécessaire après les tests d'activation :
-- INSERT INTO user_goals_plan (goal_id, regime_id, activity_id, minutes_per_day, created_at, updated_at) VALUES
-- (1, 2, 2, 30, NOW(), NOW()),
-- (2, 3, 3, 45, NOW(), NOW());

-- Les utilisations (rédemptions) de coupons sont créées lorsque les coupons sont appliqués.
-- Exemple de rédemption manuelle pour test si nécessaire :
-- INSERT INTO coupon_redemptions (user_id, coupon_id, amount, redeemed_at, created_at, updated_at) VALUES
-- (1, 1, 500.00, NOW(), NOW(), NOW());