CREATE TABLE situacion (
    idSituacion smallint unsigned AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    informacion VARCHAR(400) NOT NULL,
    imagen CHAR(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE problema (
    idProblema smallint unsigned PRIMARY KEY,
    reflexion VARCHAR(400) NOT NULL,
    CONSTRAINT fk_problema_situacion FOREIGN KEY (idProblema) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE conflicto(
    idConflicto smallint unsigned PRIMARY KEY,
    numMotivo tinyint DEFAULT NULL,
    fechaInicio date NOT NULL,
    CONSTRAINT fk_conflicto_situacion FOREIGN KEY (idConflicto) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE motivo(
    idConflicto smallint unsigned,
    numMotivo tinyint,
    textoMotivo VARCHAR(400) NOT NULL,
    PRIMARY KEY(idConflicto, numMotivo),
    CONSTRAINT fk_motivo_conflicto FOREIGN KEY (idConflicto) REFERENCES situacion (idSituacion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE conflicto
ADD CONSTRAINT fk_conflicto_motivo FOREIGN KEY (idConflicto, numMotivo) REFERENCES motivo (idConflicto, numMotivo);
