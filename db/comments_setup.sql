CREATE TABLE IF NOT EXISTS `order_comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `comment_text` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_orders_idx` (`order_id` ASC),
  CONSTRAINT `fk_comments_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `orders` (`order_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE = InnoDB;
