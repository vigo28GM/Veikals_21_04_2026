-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema store_dev
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema store_dev
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `store_dev` DEFAULT CHARACTER SET utf8 ;
USE `store_dev` ;

-- -----------------------------------------------------
-- Table `store_dev`.`customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `store_dev`.`customers` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `birthday` DATE NULL,
  `points` INT NULL,
  PRIMARY KEY (`customer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store_dev`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `store_dev`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NULL,
  `status` VARCHAR(45) NULL,
  `comments` VARCHAR(45) NULL,
  `arrived_at` DATE NULL,
  `customer_id` INT NOT NULL,
  PRIMARY KEY (`order_id`, `customer_id`),
  INDEX `fk_orders_customers_idx` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `fk_orders_customers`
    FOREIGN KEY (`customer_id` )
    REFERENCES `store_dev`.`customers` (`customer_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

insert into customers(name,last_name,email,birthday,points)
values("Steve","Minecraft","Steve@minecraft.com","2001-08-02", 242),
("Jeffry","Pork","JerryPork@minecraft.com","2021-02-02", 242),
("John","Undertale","Johnunder@minecraft.com","2006-04-22", 242),
("Roblox","Roblox","roblox@minecraft.com","2000-04-02", 242);


insert into orders(date,status,comments,arrived_at,customer_id)
values("2021-01-04","arrived","bro it was lit","2020-02-01",1),
("2025-06-07","lost","bro it was lost","2026-02-01",2),
("2027-04-22","damaged","bro it was droped","2052-02-01",3),
("2025-02-12","not found","bro it was idk","2024-02-01",1),
("2012-07-26","sold","bro it was sheap","2023-02-01",2),
("2012-05-12","forgot","why?","2020-02-01",2),
("2024-02-16","arrived","bro it was lit","2026-02-01",3);
