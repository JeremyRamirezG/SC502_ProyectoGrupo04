CREATE TABLE `centrodesalud`.`tab_usuarios` (
    `Cédula` VARCHAR(255) NOT NULL,
    `PrimerNombre` VARCHAR(100) NOT NULL,
    `SegundoNombre` VARCHAR(100) NULL,
    `PrimerApellido` VARCHAR(100) NOT NULL,
    `SegundoApellido` VARCHAR(100) NOT NULL,
    `Teléfono` VARCHAR(100) NOT NULL,
    `Correo` VARCHAR(100) NOT NULL,
    `Contraseña` VARCHAR(255) NOT NULL,
    `TipoSangre` VARCHAR(2) NULL,
    `Estatura` DOUBLE NULL,
    `Peso` DOUBLE NULL,
    PRIMARY KEY (`Cédula`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_citas` (
    `CodCita` INT NOT NULL AUTO_INCREMENT,
    `Fecha` DATE NOT NULL,
    `Especialidad` VARCHAR(100) NOT NULL,
    `MétodoReserva` VARCHAR(100) NOT NULL,
    `Descripción` VARCHAR(510) NOT NULL,
    `Estado` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`CodCita`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_examenesmedicos` (
    `CodExamen` INT NOT NULL AUTO_INCREMENT,
    `Fecha` DATE NOT NULL,
    `Tipo` VARCHAR(100) NOT NULL,
    `Resultado` VARCHAR(255) NOT NULL,
    `Descripción` VARCHAR(510) NOT NULL,
    `Estado` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`CodExamen`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_roles` (
    `CodRol` INT NOT NULL AUTO_INCREMENT,
    `Descripción` VARCHAR(510) NOT NULL,
    PRIMARY KEY (`CodRol`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_alergias` (
    `CodAlergia` INT NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(100) NOT NULL,
    `Descripción` VARCHAR(510) NOT NULL,
    `Tipo` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`CodAlergia`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_historialmedico` (
    `CodHistorial` INT NOT NULL AUTO_INCREMENT,
    `Enfermedad` VARCHAR(100) NOT NULL,
    `Descripción` VARCHAR(510) NOT NULL,
    `Tipo` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`CodHistorial`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_feedback` (
    `CodFeedback` INT NOT NULL AUTO_INCREMENT,
    `Titulo` VARCHAR(100) NOT NULL,
    `Area` VARCHAR(100) NOT NULL,
    `Descripción` VARCHAR(510) NOT NULL,
    `Calificacion` INT NOT NULL,
    PRIMARY KEY (`CodFeedback`)
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_citasusuario` (
    `CodCita` INT NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cédula`, `CodCita`),
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`CodCita`) REFERENCES `tab_citas`(`CodCita`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_examenesmedicosusuario` (
    `CodExamen` INT NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cédula`, `CodExamen`),
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`CodExamen`) REFERENCES `tab_examenesmedicos`(`CodExamen`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_contactoemergencia` (
    `CodContacto` INT NOT NULL AUTO_INCREMENT,
    `Nombre` VARCHAR(100) NOT NULL,
    `Ubicacion` VARCHAR(100) NOT NULL,
    `Telefono` VARCHAR(100) NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`CodContacto`),
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_rolesusuario` (
    `CodRol` INT NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cédula`, `CodRol`),
    FOREIGN KEY (`CodRol`) REFERENCES `tab_roles`(`CodRol`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_alergiasusuario` (
    `CodAlergia` INT NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cédula`, `CodAlergia`),
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`CodAlergia`) REFERENCES `tab_alergias`(`CodAlergia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `centrodesalud`.`tab_historialmedicousuario` (
    `CodHistorial` INT NOT NULL,
    `Cédula` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cédula`, `CodHistorial`),
    FOREIGN KEY (`CodHistorial`) REFERENCES `tab_historialmedico`(`CodHistorial`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Cédula`) REFERENCES `tab_usuarios`(`Cédula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO `tab_roles`(`Descripción`) VALUES ('ROL_CLIENTE'),('ROL_EMPLEADO'),('ROL_ADMIN');
INSERT INTO `tab_usuarios`(`Cédula`, `PrimerNombre`, `SegundoNombre`, `PrimerApellido`, `SegundoApellido`, `Teléfono`, `Correo`, `Contraseña`) VALUES ('118420454','Jeremy','Andres','Ramirez','Gonzalez','87370422','jrg7148@gmail.com','$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6'); --Password@123
INSERT INTO `tab_rolesusuario`(`CodRol`, `Cédula`) VALUES ('1','118420454'), ('2','118420454'), ('3','118420454');

INSERT INTO `tab_citas`(`Fecha`, `Especialidad`, `MétodoReserva`, `Descripción`, `Estado`) VALUES (now(),'Pedicurista','App','Cita para uña encarnada.','Pendiente'), (now(),'Cardiología','App','Cita para electrocardiograma.','Pendiente'), (now(),'General','App','Cita para revisión anual.','Cancelada');

INSERT INTO `tab_citasusuario`(`CodCita`, `Cédula`) VALUES ('1','118420454'), ('2','118420454'), ('3','118420454');
ALTER TABLE tab_usuarios ADD COLUMN Avatar LONGBLOB;