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

CREATE TABLE regime(
    id PRIMARY KEY AUTO_INCREMENT,
    viande FLOAT NOT NULL,
    poisson FLOAT NOT NULL,
    volaille FLOAT NOT NULL,
    duree INT NOT NULL,
    prix FLOAT
);

CREATE TABLE userRegime(
    id_user INT NOT NULL,
    id_regime INT NOT NULL,
    id_sport INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_regime) REFERENCES regime(id),
    FOREIGN KEY (id_sport) REFERENCES sport(id),

);
