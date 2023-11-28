CREATE TABLE ranking (
    idPartida MEDIUMINT unsigned AUTO_INCREMENT PRIMARY KEY,
    puntuacion tinyint unsigned NOT NULL,
    nombreJugador CHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
