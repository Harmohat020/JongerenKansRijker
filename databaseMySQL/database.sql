
DROP DATABASE IF EXISTS jongerenkansrijker;

CREATE DATABASE  jongerenkansrijker;

USE jongerenkansrijker;

CREATE TABLE activiteit(
    ID INT NOT NULL AUTO_INCREMENT,
    activiteit VARCHAR(40),
    PRIMARY KEY(ID)
);

CREATE TABLE instituut(
    ID INT NOT NULL AUTO_INCREMENT,
    instituut VARCHAR(40),
    instituuttelefoon VARCHAR(11),
    PRIMARY KEY(ID)
);

CREATE TABLE usertype (
    ID INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(255),
    PRIMARY KEY(ID)
);

CREATE TABLE account_administrator (
    ID INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    usertype_id INT NOT NULL,
    FOREIGN KEY (usertype_id) REFERENCES usertype(ID),
    PRIMARY KEY(ID)
);

CREATE TABLE administrator(
    ID INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(255),
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255),
    account_id INT NOT NULL,
    FOREIGN KEY (account_id) REFERENCES account_administrator(ID),
    PRIMARY KEY(ID)
);

CREATE TABLE jongere(
    ID INT NOT NULL AUTO_INCREMENT,
    roepnaam VARCHAR(255),
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    geboortedatum DATE,
    inschrijfdatum DATE,
    PRIMARY KEY(ID)
);

CREATE TABLE jongereactiviteit(
    ID INT NOT NULL AUTO_INCREMENT,
    jongereID INT NOT NULL,
    activiteitID INT NOT NULL,
    startdatum DATE,
    afgerond TINYINT(1),
    FOREIGN KEY (jongereID) REFERENCES jongere(ID),
    FOREIGN KEY (activiteitID) REFERENCES activiteit(ID),
    PRIMARY KEY(ID)
);

CREATE TABLE jongereinstituut(
    ID INT NOT NULL AUTO_INCREMENT,
    jongereID INT NOT NULL,
    instituutsID INT NOT NULL,
    startdatum DATE,
    FOREIGN KEY (jongereID) REFERENCES jongere(ID),
    FOREIGN KEY (instituutsID) REFERENCES instituut(ID),
    PRIMARY KEY(ID)
);


INSERT INTO usertype(ID, type)
        VALUES
        (NULL,'administrator'),
        (NULL,'user')

