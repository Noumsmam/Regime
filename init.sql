DROP DATABASE IF EXISTS EtudiantNote;
CREATE DATABASE EtudiantNote;
USE EtudiantNote;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    etudiant_id VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE etat(
    id INT PRIMARY KEY AUTO_INCREMENT,
    statut VARCHAR(50)
);

CREATE TABLE semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    credits INT NOT NULL,
    etat_id INT,
    semestre_id INT,
    FOREIGN KEY (etat_id) REFERENCES etat(id),
    FOREIGN KEY (semestre_id) REFERENCES semestre(id)
);


CREATE TABLE options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE note (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    option_id INT NOT NULL,
    matiere_id INT NOT NULL,
    note DOUBLE NOT NULL,
    FOREIGN KEY (option_id) REFERENCES options(id),
    FOREIGN KEY (etudiant_id) REFERENCES etudiant(id),
    FOREIGN KEY (matiere_id) REFERENCES matiere(id)
);
