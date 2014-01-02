SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `planetshop_db` ;
CREATE SCHEMA IF NOT EXISTS `planetshop_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `planetshop_db` ;

-- -----------------------------------------------------
-- Table `planetshop_db`.`user_role`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`user_role` (
  `role_id` INT NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`galaxy`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`galaxy` (
  `galaxy_id` INT NOT NULL AUTO_INCREMENT COMMENT '		' ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`galaxy_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`planet`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`planet` (
  `planet_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`planet_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`address`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`address` (
  `address_id` INT NOT NULL AUTO_INCREMENT ,
  `address_name` VARCHAR(45) NULL ,
  `street` VARCHAR(45) NULL ,
  `zipcode` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `country` VARCHAR(45) NULL ,
  `galaxy_id` INT NULL ,
  `planet_id` INT NULL ,
  PRIMARY KEY (`address_id`) ,
  INDEX `fk_galaxy_idx` (`galaxy_id` ASC) ,
  INDEX `fk_planet_idx` (`planet_id` ASC) ,
  CONSTRAINT `fk_galaxy`
    FOREIGN KEY (`galaxy_id` )
    REFERENCES `planetshop_db`.`galaxy` (`galaxy_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_planet`
    FOREIGN KEY (`planet_id` )
    REFERENCES `planetshop_db`.`planet` (`planet_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(32) NOT NULL ,
  `password` VARCHAR(32) NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `last_login` DATETIME NULL ,
  `role_id` INT NULL DEFAULT 2 ,
  `address_id` INT NULL ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_role_idx` (`role_id` ASC) ,
  INDEX `fk_address_idx` (`address_id` ASC) ,
  CONSTRAINT `fk_role`
    FOREIGN KEY (`role_id` )
    REFERENCES `planetshop_db`.`user_role` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_address`
    FOREIGN KEY (`address_id` )
    REFERENCES `planetshop_db`.`address` (`address_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product_category` (
  `category_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `translation_string` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`category_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product` (
  `product_id` INT NOT NULL AUTO_INCREMENT ,
  `product_category` INT NULL ,
  `name` VARCHAR(50) NOT NULL ,
  `description` TEXT NULL ,
  `product_picture` VARCHAR(50) NULL ,
  `price` DECIMAL(15,2) NULL ,
  `delivery_days` INT NULL ,
  `inventory_quantity` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`product_id`) ,
  INDEX `fk_product_category_idx` (`product_category` ASC) ,
  CONSTRAINT `fk_product_category`
    FOREIGN KEY (`product_category` )
    REFERENCES `planetshop_db`.`product_category` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product_attribute`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product_attribute` (
  `attribute_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `description` TEXT NULL ,
  `value_range` VARCHAR(100) NULL ,
  `value_unit` VARCHAR(100) NULL ,
  `default_value` VARCHAR(100) NULL ,
  PRIMARY KEY (`attribute_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`order`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`order` (
  `order_id` INT NOT NULL ,
  `customer_id` INT NOT NULL ,
  `order_date` DATETIME NULL ,
  `shipping_date` DATETIME NULL ,
  `shipping_address` INT NULL ,
  PRIMARY KEY (`order_id`, `customer_id`) ,
  INDEX `fk_customer_idx` (`customer_id` ASC) ,
  INDEX `fk_shipping_addr_idx` (`shipping_address` ASC) ,
  CONSTRAINT `fk_customer`
    FOREIGN KEY (`customer_id` )
    REFERENCES `planetshop_db`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shipping_addr`
    FOREIGN KEY (`shipping_address` )
    REFERENCES `planetshop_db`.`address` (`address_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`order_detail`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`order_detail` (
  `order_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NOT NULL ,
  `quantity` INT NULL ,
  PRIMARY KEY (`order_id`, `product_id`) ,
  INDEX `fk_product_idx` (`product_id` ASC) ,
  CONSTRAINT `fk_product`
    FOREIGN KEY (`product_id` )
    REFERENCES `planetshop_db`.`product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order`
    FOREIGN KEY (`order_id` )
    REFERENCES `planetshop_db`.`order` (`order_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product_attribute_value`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product_attribute_value` (
  `attribute_value_id` INT NOT NULL AUTO_INCREMENT ,
  `product_id` INT NOT NULL ,
  `product_attribute_id` INT NOT NULL ,
  `value` VARCHAR(100) NULL ,
  PRIMARY KEY (`attribute_value_id`) ,
  INDEX `fk_prod_attr_val_prod_idx` (`product_id` ASC) ,
  UNIQUE INDEX `uq_prod_attr` (`product_id` ASC, `product_attribute_id` ASC) ,
  INDEX `idx_pav_prod_id` (`product_id` ASC) ,
  INDEX `idx_pav_prod_id_attr_id` (`product_id` ASC, `product_attribute_id` ASC) ,
  CONSTRAINT `fk_prod_attr_val_prod`
    FOREIGN KEY (`product_id` )
    REFERENCES `planetshop_db`.`product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prod_attr`
    FOREIGN KEY (`product_attribute_id` )
    REFERENCES `planetshop_db`.`product_attribute` (`attribute_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`order_detail_attributes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`order_detail_attributes` (
  `order_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `attribute_id` INT NOT NULL ,
  `attribute_value` VARCHAR(100) NULL ,
  PRIMARY KEY (`order_id`, `product_id`, `attribute_id`) ,
  INDEX `fk_order_id_idx` (`order_id` ASC, `product_id` ASC) ,
  INDEX `fk_attribute_id_idx` (`attribute_id` ASC) ,
  CONSTRAINT `fk_order_id`
    FOREIGN KEY (`order_id` , `product_id` )
    REFERENCES `planetshop_db`.`order_detail` (`order_id` , `product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attribute_id`
    FOREIGN KEY (`attribute_id` )
    REFERENCES `planetshop_db`.`product_attribute` (`attribute_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `planetshop_db` ;

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `planetshop_db`.* TO 'planetshop_user'@'localhost';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`user_role`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`user_role` (`role_id`, `role_name`) VALUES (1, 'Administrator');
INSERT INTO `planetshop_db`.`user_role` (`role_id`, `role_name`) VALUES (2, 'Customer');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`galaxy`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`galaxy` (`galaxy_id`, `name`) VALUES (1, 'Milky Way');
INSERT INTO `planetshop_db`.`galaxy` (`galaxy_id`, `name`) VALUES (2, 'Andromeda');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`planet`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Mercury');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Venus');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Earth');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Mars');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Jupiter');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Saturn');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Uranus');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Neptun');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Pluto');
INSERT INTO `planetshop_db`.`planet` (`planet_id`, `name`) VALUES (NULL, 'Nano');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_login`, `role_id`, `address_id`) VALUES (1, 'simon', '43b90920409618f188bfc6923f16b9fa', 'simon@krenger.ch', 'Simon', 'Krenger', NULL, 1, NULL);
INSERT INTO `planetshop_db`.`user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_login`, `role_id`, `address_id`) VALUES (2, 'fraenzi', '609d83e477224ce84d757e25c3001acc', 'fraenzi@blah.com', 'Fränzi', 'Corradi', NULL, 1, NULL);
INSERT INTO `planetshop_db`.`user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_login`, `role_id`, `address_id`) VALUES (3, 'dr.einstein', '37a08ed30093a133b1bb4ae0b8f3601f', 'einstein@nano.universe', 'Albert', 'Einstein', NULL, NULL, NULL);
INSERT INTO `planetshop_db`.`user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_login`, `role_id`, `address_id`) VALUES (4, 'sophii', 'c0bd97dba5751dc2c7797b66fca9280c', 'sophii@summers.universe', 'Sophii', 'Summers', NULL, NULL, NULL);
INSERT INTO `planetshop_db`.`user` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `last_login`, `role_id`, `address_id`) VALUES (5, 'polpotcx', '101e06710423e2610d4c77868636b2c6', 'polpotcx@dictators.universe', 'PolPotCX\n', 'Dictator', NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product_category`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product_category` (`category_id`, `name`, `translation_string`) VALUES (1, 'Predefined planet', 'MENU_PREDEFINED');
INSERT INTO `planetshop_db`.`product_category` (`category_id`, `name`, `translation_string`) VALUES (2, 'Planets on sale', 'MENU_ON_SALE');
INSERT INTO `planetshop_db`.`product_category` (`category_id`, `name`, `translation_string`) VALUES (3, 'Custom planets', 'MENU_CUSTOM');
INSERT INTO `planetshop_db`.`product_category` (`category_id`, `name`, `translation_string`) VALUES (4, 'Natural satellites', 'MENU_SATELLITES');
INSERT INTO `planetshop_db`.`product_category` (`category_id`, `name`, `translation_string`) VALUES (5, 'Accessories', 'MENU_ACCESSORIES');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (1, 1, 'Terrestrial Planet N39482', 'A super planet for the planetary beginner!', 'generic_planet_white.png', 10000000.00, 3, 28);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (2, 1, 'Desert Planet', 'The cheaper alternative', 'generic_planet_white.png', 6000000.00, 3, 5);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (3, 1, 'Ice Planet', 'A planet where vegetation is not necessary', 'generic_planet_white.png', 8000000.00, 4, 12);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (4, 1, 'Lava Planet', 'A hot planet!', 'generic_planet_white.png', 7000000.00, 3, 4);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (5, 1, 'Ocean Planet', 'For everyone fond of dolphins', 'generic_planet_white.png', 12000000.00, 5, 3);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (6, 1, 'Gas Planet', 'Something lighter...', 'generic_planet_white.png', 4000000.00, 3, 38);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (7, 2, 'Planet #329-234-907', 'Used! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nisl nulla, posuere nec nibh sed, vestibulum porttitor sed.', 'generic_planet_white.png', 2200000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (9, 2, 'Planet #808-837-666', 'Used!', 'generic_planet_white.png', 6660000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (10, 2, 'Planet #000-029-203', 'Used', 'generic_planet_white.png', 9600000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (11, 3, 'Custom terrestrial planet', 'The planet just for you!', 'generic_planet_white.png', 20000000.00, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (12, 3, 'Custom ocean planet', 'Made just for you!', 'generic_planet_white.png', 20000000.00, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (13, 3, 'Custom gas planet', 'Tailored', 'generic_planet_white.png', 20000000.00, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (14, 4, 'Regular moon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel hendrerit lorem. Cras malesuada, justo a ultrices ullamcorper, dui lorem tempor lacus, eu aliquet dui metus at diam. Nulla scelerisque ullamcorper hendrerit. Curabitur ante nisi, vehicula vitae tincidunt non, molestie convallis libero. Sed quis velit sapien. Sed pulvinar turpis vel turpis ornare vehicula. Nullam et ante vel magna pellentesque posuere. Maecenas lacus enim, facilisis at tincidunt in, lobortis eleifend neque. Aliquam massa libero, mattis vitae dui nec, tincidunt feugiat nisl.\n\nUt vel lobortis enim. Donec vehicula libero vitae libero congue, a imperdiet odio tempor. Morbi sagittis nulla in nisl vestibulum tempus ut sit amet elit. Vivamus feugiat tortor nisl. Suspendisse ornare viverra est tempus dictum. Duis nec purus mi. Aenean.', 'generic_planet_white.png', 2000000, 5, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (15, 4, 'Asteroid moon', 'An awesome asteroid moon. But to be honest, we do not exactly know the difference between this asteroid moon and the regular moon. We guess this one is just a little bit fancier or something. At least it costs a bit more...', 'generic_planet_white.png', 3000000, 4, 11);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (16, 4, 'Ice moon', 'A really cold moon for those that like it cool.', 'generic_planet_white.png', 1500000, 5, 4);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (17, 4, 'Trojan', 'Also with this one, we have no freaking idea what this is', 'generic_asteroid_white.png', 200000, 10, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (18, 5, 'Meteor field', 'A simple meteor field', 'generic_asteroid_white.png', 500000, 5, 16);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (19, 5, 'Nebula', 'A nebulous nebula, available in multiple colors.', NULL, 15000000, 19, 2);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (20, 5, 'Planet ring', 'Planetary rings available in multiple sizes', NULL, 1000000, 5, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (21, 5, 'Meteorite insurance', 'Insurance against meteorite showers', NULL, 50000000, 5, 1000);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (22, 5, 'Supernova', 'Big Boom! But takes 5 weeks to deliver', NULL, 500000000, 25, 2);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (23, 5, 'Comet', 'A comet that may or may not stay within orbit around a planet', 'generic_asteroid_white.png', 100000, 2, 493);

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product_attribute`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (1, 'Diameter', 'Diameter of your product', '10...120', '\'000 km', '20');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (2, 'Surface', 'Surface type', 'Terrestrial (Ice),Terrestrial (Land),Terrestrial (Land/Water),Fluid,Gas', NULL, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (3, 'Mass', 'Mass of the planet', '1...100', ' * 10^25 kg', '25');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (4, 'Axial tilt', 'The axial tilt in degrees', '0...10', ' °', '7');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (5, 'Average temperature', 'Temperature of the surface (determined by the distance from the next sun)', '1...1000', ' Kelvin', '293');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (6, 'Color', 'Color of the nebula', 'Multicolor,Red,Green,Yellow,Blue,Random', NULL, 'Red');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (7, 'Ring size', 'Size of the planetary ring', 'Extra small,Small,Medium,Large,Extra Large', NULL, 'Medium');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (8, 'Surface', 'Surface type', 'Terrestrial (Ice),Terrestrial (Land),Terrestrial (Land/Water)', NULL, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `name`, `description`, `value_range`, `value_unit`, `default_value`) VALUES (9, 'Debris size', 'Size of the rocks flying around your planet', 'Dust,Small,Medium,Large', NULL, 'Medium');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product_attribute_value`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 1, 1, '6');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 1, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 1, 3, '70');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 1, 4, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 19, 6, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 11, 1, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 11, 8, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 11, 3, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 11, 4, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 11, 5, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 12, 1, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 12, 2, 'Terrestrial (Water)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 12, 3, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 12, 4, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 12, 5, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 13, 1, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 13, 2, 'Gas');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 13, 3, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 13, 4, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 13, 5, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 20, 1, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 20, 9, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 2, 1, '40');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 2, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 2, 3, '30');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 2, 4, '2');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 2, 5, '353');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 3, 1, '12');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 3, 2, 'Terrestrial (Ice)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 3, 3, '15');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 3, 4, '9');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 3, 5, '200');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 4, 1, '80');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 4, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 4, 3, '75');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 4, 4, '10');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 4, 5, '460');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 5, 1, '12');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 5, 2, 'Terrestrial (Land/Water)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 5, 3, '55');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 5, 4, '3');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 5, 5, '301');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 6, 1, '120');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 6, 2, 'Gas');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 6, 3, '12');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 6, 4, '9');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 6, 5, '500');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 7, 1, '45');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 7, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 7, 3, '60');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 7, 4, '3');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 7, 5, '298');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 9, 1, '110');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 9, 2, 'Gas');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 9, 3, '36');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 9, 4, '1');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 9, 5, '490');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 10, 1, '10');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 10, 2, 'Terrestrial (Ice)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 10, 3, '60');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 10, 4, '2');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 10, 5, '123');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 14, 1, '10');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 14, 3, '5');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 14, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 15, 1, '12');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 15, 2, 'Terrestrial (Land)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 15, 3, '7');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 16, 1, '10');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 16, 2, 'Terrestrial (Ice)');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 16, 3, '12');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 17, 1, '20');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 18, 9, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 22, 6, 'Red');
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 23, 1, NULL);
INSERT INTO `planetshop_db`.`product_attribute_value` (`attribute_value_id`, `product_id`, `product_attribute_id`, `value`) VALUES (NULL, 23, 3, NULL);

COMMIT;
