-- Datubāzes pamatstruktūras izveides skripts
-- Izveido shēmu un pamatgaldiņus: klientus un pasūtījumus

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Shēmas (Database) izveide
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `store_dev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `store_dev` ;

-- -----------------------------------------------------
-- Tabula `customers` - Glabā informāciju par klientiem
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL COMMENT 'Klienta vārds',
  `last_name` VARCHAR(45) NULL COMMENT 'Klienta uzvārds',
  `email` VARCHAR(100) NULL COMMENT 'E-pasta adrese paziņojumiem',
  `birthday` DATE NULL COMMENT 'Dzimšanas diena lojalitātes programmām',
  `points` INT DEFAULT 0 COMMENT 'Uzkrātie punkti',
  PRIMARY KEY (`customer_id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabula `orders` - Glabā pasūtījumu pamatdatus
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NULL COMMENT 'Pasūtījuma veikšanas datums',
  `status` VARCHAR(45) NULL COMMENT 'Statuss: Jauns, Procesā, Pabeigts, utt.',
  `comments` TEXT NULL COMMENT 'Papildus piezīmes par pasūtījumu',
  `arrived_at` DATE NULL COMMENT 'Faktiskais piegādes datums',
  `customer_id` INT NOT NULL COMMENT 'Saite uz klientu tabulu',
  PRIMARY KEY (`order_id`),
  INDEX `fk_orders_customers_idx` (`customer_id` ASC),
  CONSTRAINT `fk_orders_customers`
    FOREIGN KEY (`customer_id`)
    REFERENCES `customers` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Sākotnējie testa dati klientu tabulai
-- -----------------------------------------------------
INSERT INTO customers(name, last_name, email, birthday, points) VALUES
("Steve", "Minecraft", "steve@example.com", "2001-08-02", 242),
("Jeffry", "Pork", "jeffry@example.com", "2021-02-02", 120),
("John", "Undertale", "john@example.com", "2006-04-22", 85),
("Roblox", "Admin", "admin@example.com", "2000-04-02", 1000);

-- -----------------------------------------------------
-- Sākotnējie testa dati pasūtījumu tabulai
-- -----------------------------------------------------
INSERT INTO orders(date, status, comments, arrived_at, customer_id) VALUES
("2021-01-04", "Pabeigts", "Viss piegādāts laicīgi", "2021-02-01", 1),
("2025-06-07", "Pazudis", "Kurjers nevarēja atrast adresi", NULL, 2),
("2024-04-22", "Bojāts", "Iepakojums sasists", "2024-05-01", 3),
("2025-02-12", "Jauns", "Gaidām apmaksu", NULL, 1);
