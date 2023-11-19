CREATE TABLE `situacion` (
    `idSituacion` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `informacion` TEXT NOT NULL,
    `imagen` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `problema` (
    `idProblema` INT(11) PRIMARY KEY,
    `reflexion` TEXT NOT NULL,
    CONSTRAINT `fk_problema_situacion` FOREIGN KEY (`idProblema`) REFERENCES `situacion` (`idSituacion`) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
