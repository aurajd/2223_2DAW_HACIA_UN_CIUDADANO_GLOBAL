CREATE TABLE continente (
    idContinente TINYINT AUTO_INCREMENT PRIMARY KEY,
    nombre CHAR(17) NOT NULL,
    informacion VARCHAR(2000) NOT NULL,
    resumenInfo VARCHAR(100) NOT NULL,
    imagen VARCHAR(18) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE situacion (
    idSituacion SMALLINT unsigned AUTO_INCREMENT PRIMARY KEY,
    idContinente TINYINT NOT NULL,
    titulo VARCHAR(50) NOT NULL,
    informacion VARCHAR(2000) NOT NULL,
    imagen CHAR(18) DEFAULT NULL,
    CONSTRAINT fk_situacion_continente FOREIGN KEY (idContinente) REFERENCES continente(idContinente);
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE problema (
    idProblema SMALLINT unsigned PRIMARY KEY,
    reflexion VARCHAR(2000) NOT NULL,
    CONSTRAINT fk_problema_situacion FOREIGN KEY (idProblema) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE conflicto(
    idConflicto SMALLINT unsigned PRIMARY KEY,
    numMotivo TINYINT DEFAULT NULL,
    fechaInicio date NOT NULL,
    CONSTRAINT fk_conflicto_situacion FOREIGN KEY (idConflicto) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE motivo(
    idConflicto SMALLINT unsigned,
    numMotivo TINYINT,
    textoMotivo VARCHAR(2000) NOT NULL,
    PRIMARY KEY(idConflicto, numMotivo),
    CONSTRAINT fk_motivo_conflicto FOREIGN KEY (idConflicto) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE solucion (
    idSituacion SMALLINT unsigned,
    numSolucion TINYINT NOT NULL,
    textoSolucion VARCHAR(2000) NOT NULL,
    correcta BIT NOT NULL,
    PRIMARY KEY(idSituacion, numSolucion),
    CONSTRAINT fk_solucion_situacion FOREIGN KEY (idSituacion) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE ranking (
    idPartida MEDIUMINT unsigned AUTO_INCREMENT PRIMARY KEY,
    puntuacion tinyint NOT NULL,
    nombreJugador CHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE conflicto
ADD CONSTRAINT fk_conflicto_motivo FOREIGN KEY (idConflicto, numMotivo) REFERENCES motivo (idConflicto, numMotivo);


ALTER TABLE situacion
ADD COLUMN idContinente TINYINT;

ALTER TABLE situacion
ADD CONSTRAINT fk_situacion_contiente FOREIGN KEY (idContinente) REFERENCES continente (idContinente);

-- Eliminar la clave externa
ALTER TABLE situacion
DROP FOREIGN KEY fk_situacion_contiente;

-- Luego, eliminar la columna idContinente
ALTER TABLE situacion
DROP COLUMN idContinente;
