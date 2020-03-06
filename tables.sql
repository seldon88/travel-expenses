 CREATE TABLE `utenti` (
  `dipendente_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(255) NULL,
  `nome` VARCHAR(45) NULL,
  `cognome` VARCHAR(45) NULL,
  `dataDiNascita` DATE NULL,
  `sesso` ENUM('M','F') NULL,
  `tipo_utente` VARCHAR(45) NULL,
  PRIMARY KEY (`dipendente_id`));
  
  
  
  CREATE TABLE `trasferte` (
  `trasferte_id` INT NOT NULL AUTO_INCREMENT,
  `destinazione` VARCHAR(45) NULL,
  `distanzaInKm` INT UNSIGNED NULL,
  `dataTrasferta` DATE NULL,
  `dipendente_id` INT,
  
`speseCarburante` INT,
`speseAggiuntive` INT,
`speseTotali` INT,
`rimborsato` BOOLEAN,

  FOREIGN KEY (`dipendente_id`) REFERENCES utenti(`dipendente_id`),
  PRIMARY KEY (`trasferte_id`));
  
  SET @DATABASE_NAME = 'viaggi';

SELECT  CONCAT('ALTER TABLE `', table_name, '` ENGINE=InnoDB;') AS sql_statements
FROM    information_schema.tables AS tb
WHERE   table_schema = @DATABASE_NAME
AND     `ENGINE` = 'MyISAM'
AND     `TABLE_TYPE` = 'BASE TABLE'
ORDER BY table_name DESC;

UPDATE table_name
SET column1 = value1, column2 = value2, ...
WHERE condition;