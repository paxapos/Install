-- Resuelve los campos faltantes para la ejecucucion correcta de la importacion de schema_base_data.sql
ALTER TABLE `productos` ADD `comandera_id` INT NOT NULL AFTER `precio`;
