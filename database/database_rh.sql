USE RH;

CREATE TABLE ESTADO (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE MUNICIPIO (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE DIRECCION (
    ID INT NOT NULL AUTO_INCREMENT,
    CALLE VARCHAR(200) NOT NULL,
    EXT VARCHAR(50),
    `INT` VARCHAR(50),
    COLONIA VARCHAR(150) NOT NULL,
    COD_POSTAL VARCHAR(5) NOT NULL,
    MUNICIPIO_ID INT NOT NULL,
    ESTADO_ID INT NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_DIRECCION_MUNICIPIO
                       FOREIGN KEY (MUNICIPIO_ID) REFERENCES MUNICIPIO(ID),
    CONSTRAINT FK_DIRECCION_ESTADO
                       FOREIGN KEY (ESTADO_ID) REFERENCES ESTADO(ID)
);

CREATE TABLE DEPARTAMENTO (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    DESCRIPCION VARCHAR(500),
    PRIMARY KEY (ID)
);

CREATE TABLE CARGO (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    NIVEL_EXP INT NOT NULL,
    SALARIO DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE EMPLEADO (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    APELLIDO_PAT VARCHAR(150) NOT NULL,
    APELLIDO_MAT VARCHAR(150) NOT NULL,
    GENERO INT NOT NULL,
    FECHA_NACIMIENTO DATE NOT NULL,
    DIRECCION_ID INT NOT NULL,
    CARGO_ID INT NOT NULL,
    CORREO VARCHAR(128) NOT NULL,
    SUPERVISOR_ID INT NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_EMPLEADO_DIRECCION
                      FOREIGN KEY (DIRECCION_ID) REFERENCES DIRECCION(ID),
    CONSTRAINT FK_EMPLEADO_CARGO
                      FOREIGN KEY (CARGO_ID) REFERENCES CARGO(ID)
);

ALTER TABLE EMPLEADO
    ADD CONSTRAINT FK_EMPLEADO_SUPERVISOR
        FOREIGN KEY (SUPERVISOR_ID) REFERENCES EMPLEADO(ID);

CREATE TABLE CONTACTO_EMERG (
    ID INT NOT NULL AUTO_INCREMENT,
    NOMBRE VARCHAR(150) NOT NULL,
    APELLIDO_PAT VARCHAR(150) NOT NULL,
    APELLIDO_MAT VARCHAR(150) NOT NULL,
    PARENTESCO VARCHAR(100) NOT NULL,
    EMPLEADO_ID INT NOT NULL,
    TELEFONO VARCHAR(15) NOT NULL,
    CORREO VARCHAR(128) NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_CONTACTO_EMERG_EMPLEADO
                            FOREIGN KEY (EMPLEADO_ID) REFERENCES EMPLEADO(ID)
);

CREATE TABLE HISTORIAL (
    ID INT NOT NULL AUTO_INCREMENT,
    CARGO VARCHAR(150) NOT NULL,
    FECHA_INICIO DATE NOT NULL,
    FECHA_TERMINACION DATE NOT NULL,
    SALARIO DECIMAL(10, 2) NOT NULL,
    EMPLEADO_ID INT NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_HISTORIAL_EMPLEADO
                       FOREIGN KEY (EMPLEADO_ID) REFERENCES EMPLEADO(ID)
);

CREATE TABLE ASISTENCIA (
    ID INT NOT NULL AUTO_INCREMENT,
    ESTADO VARCHAR(10) NOT NULL,
    FECHA DATETIME NOT NULL,
    EMPLEADO_ID INT NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_ASISTENCIA_EMPLEADO
                        FOREIGN KEY (EMPLEADO_ID) REFERENCES EMPLEADO(ID)
);