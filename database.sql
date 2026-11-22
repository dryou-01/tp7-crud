-- TP7 : centre de formation
DROP DATABASE IF EXISTS tp7_crud;
CREATE DATABASE tp7_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tp7_crud;

CREATE TABLE formations (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    titre        VARCHAR(100) NOT NULL,
    duree_mois   INT NOT NULL,
    description  TEXT
) ENGINE=InnoDB;

CREATE TABLE etudiants (
    id_etudiant  INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(60)  NOT NULL,
    prenom       VARCHAR(60)  NOT NULL,
    email        VARCHAR(120) NOT NULL UNIQUE,
    id_formation INT NOT NULL,
    CONSTRAINT fk_etudiant_formation FOREIGN KEY (id_formation)
        REFERENCES formations(id_formation)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE modules (
    id_module      INT AUTO_INCREMENT PRIMARY KEY,
    intitule       VARCHAR(100) NOT NULL,
    volume_horaire INT NOT NULL,
    id_formation   INT NOT NULL,
    CONSTRAINT fk_module_formation FOREIGN KEY (id_formation)
        REFERENCES formations(id_formation)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO formations (titre, duree_mois, description) VALUES
('Développement Web Full Stack', 12, 'HTML, CSS, JavaScript, PHP, MySQL'),
('DevOps et Cloud', 9, 'Docker, CI/CD, Linux, déploiement'),
('Data et Intelligence Artificielle', 10, 'Python, statistiques, machine learning');

INSERT INTO etudiants (nom, prenom, email, id_formation) VALUES
('Ahmadi', 'Sara', 'sara.Ahmadi@example.com', 1),
('Binina', 'Youssef', 'youssef.Binina@example.com', 1),
('Bertan', 'Imane', 'imane.Bertan@example.com', 2),
('Tachtach', 'Omar', 'omar.Tachtach@example.com', 3);

INSERT INTO modules (intitule, volume_horaire, id_formation) VALUES
('PHP et PDO', 40, 1),
('JavaScript avancé', 45, 1),
('Docker', 30, 2),
('GitLab CI/CD', 25, 2),
('Python pour la data', 50, 3);
