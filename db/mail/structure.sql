CREATE TABLE `mail` (
`id` SERIAL NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`email` TINYTEXT NOT NULL ,
`html` LONGTEXT NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Contenido enviado por email para el -si no ves-';


-- alters
ALTER TABLE `mail` ADD `template` int( 20 ) NULL ,
ADD `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `mail` ADD `node` VARCHAR( 50 ) NULL AFTER `template` ;

-- para verificaciones de idioma alternativo
ALTER TABLE `mail`  ADD `lang` VARCHAR(2) NULL DEFAULT NULL COMMENT 'Idioma en el que se solicit� la plantilla'

-- almacenamiento del html en Amazon S3
ALTER TABLE `mail` ADD `content` VARCHAR(50) NULL DEFAULT NULL COMMENT 'ID del archivo con HTML est�tico';

-- cuando se pueda quitar...
ALTER TABLE `mail` DROP `html`;
