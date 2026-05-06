INSERT INTO user (username, password) VALUES
	('user1', 'pass123'),
	('user2', 'pass123'),
	('user3', 'pass123'),
	('user4', 'pass123'),
	('user5', 'pass123');

INSERT INTO etudiant (nom, prenom, etudiant_id, email) VALUES
    ('Rakoto', 'Tiana', 'ETU001', 'tiana.rakoto@example.com'),
    ('Rabe', 'Mamy', 'ETU002', 'mamy.rabe@example.com'),
    ('Razafy', 'Aina', 'ETU003', 'aina.razafy@example.com'),
    ('Randria', 'Soa', 'ETU004', 'soa.randria@example.com'),
    ('Rasoa', 'Lala', 'ETU005', 'lala.rasoa@example.com');

INSERT INTO etat (statut) VALUES
	('obligatoire'),
    ('optionnelle'),
    ('maths');

INSERT INTO semestre (nom) VALUES
    ('S3'),
    ('S4');

INSERT INTO matiere (nom, credits, etat_id, semestre_id) VALUES
    ('INF201 - Programmation orientee objet', 6, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3')),
    ('INF202 - Bases de donnees objets', 6, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3')),
    ('INF203 - Programmation systeme', 4, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3')),
    ('INF208 - Reseaux informatiques', 6, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3')),
    ('MTH201 - Methodes numeriques', 4, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3')),
    ('ORG201 - Bases de gestion', 4, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S3'));

INSERT INTO matiere (nom, credits, etat_id, semestre_id) VALUES
    ('INF204 - Systeme information geographique', 6, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('INF205 - Systeme information', 6, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('INF206 - Interface Homme/Machine', 6, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('INF207 - Elements algorithmique', 6, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('INF210 - Mini-projet de developpement', 10, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('MTH204 - Geometrie', 4, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('MTH205 - Equations differentielles', 4, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('MTH206 - Optimisation', 4, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('MTH203 - MAO', 4, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S4'));

INSERT INTO matiere (nom, credits, etat_id, semestre_id) VALUES
    ('INF209 - Web dynamique', 6, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('INF212 - Mini-projet de Web et design', 10, (SELECT id FROM etat WHERE statut = 'obligatoire'), (SELECT id FROM semestre WHERE nom = 'S4')),
    ('MTH202 - Analyse des donnees', 4, (SELECT id FROM etat WHERE statut = 'optionnelle'), (SELECT id FROM semestre WHERE nom = 'S4'));

INSERT INTO options (nom) VALUES
    ('Global'),
    ('Developpement'),
    ('Base de donnees et Reseaux'),
    ('web et design');

