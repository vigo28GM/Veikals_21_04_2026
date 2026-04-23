-- Lietotāju tabulas izveide sistēmas piekļuvei
-- Nodrošina autentifikācijas iespējas

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL COMMENT 'Unikāls lietotājvārds',
  `email` VARCHAR(100) NOT NULL COMMENT 'Lietotāja e-pasts',
  `password` VARCHAR(255) NOT NULL COMMENT 'Šifrēta parole (bcrypt)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Reģistrācijas laiks',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
) ENGINE = InnoDB;
