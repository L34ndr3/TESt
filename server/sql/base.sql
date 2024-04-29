SET NAMES utf8mb4;

DROP DATABASE IF EXISTS cartesgraphiques;
CREATE DATABASE cartesgraphiques;
USE cartesgraphiques;

CREATE TABLE marque (
	id INT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(64),
	PRIMARY KEY(id)
);

CREATE TABLE carte (
	id INT NOT NULL AUTO_INCREMENT,
	nom VARCHAR(64), 
	prix FLOAT,
	marque_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(marque_id) REFERENCES marque(id) ON DELETE CASCADE
);

INSERT INTO marque (id, nom) VALUES
(1, "Nvidia"),
(2, "AMD");

INSERT INTO carte (id, nom, prix, marque_id) VALUES
(1, "RTX 4070", 650, 1),
(2, "RTX 4060", 330, 1),
(3, "RTX 4080", 1320, 1),
(4, "RTX 4090", 1800, 1),
(5, "RX7900XT", 1000, 2),
(6, "RX7900XTX", 1115, 2),
(7, "RX7600", 300, 2);
