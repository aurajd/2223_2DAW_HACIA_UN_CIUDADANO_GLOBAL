CREATE TABLE situacion (
    idSituacion INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    informacion TEXT NOT NULL,
    imagen CHAR(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE problema (
    idProblema INT PRIMARY KEY,
    reflexion TEXT NOT NULL,
    CONSTRAINT fk_problema_situacion FOREIGN KEY (idProblema) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
