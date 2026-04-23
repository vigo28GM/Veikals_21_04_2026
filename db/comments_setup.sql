-- Pasūtījumu komentāru tabulas izveide
-- Atļauj vairākus komentārus vienam pasūtījumam

CREATE TABLE IF NOT EXISTS `order_comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL COMMENT 'Saite uz pasūtījumu',
  `comment_text` TEXT NOT NULL COMMENT 'Komentāra saturs',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Pievienošanas laiks',
  PRIMARY KEY (`id`),
  INDEX `fk_comments_orders_idx` (`order_id` ASC),
  CONSTRAINT `fk_comments_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `orders` (`order_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
