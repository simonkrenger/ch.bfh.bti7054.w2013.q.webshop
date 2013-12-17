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
-- Table `planetshop_db`.`product_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product_type` (
  `type_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product` (
  `product_id` INT NOT NULL AUTO_INCREMENT ,
  `product_type` INT NULL ,
  `product_category` INT NULL ,
  `name` VARCHAR(50) NOT NULL ,
  `description` TEXT NULL ,
  `product_picture` BLOB NULL ,
  `price` DECIMAL(15,2) NULL ,
  `delivery_days` INT NULL ,
  `inventory_quantity` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`product_id`) ,
  INDEX `fk_product_category_idx` (`product_category` ASC) ,
  INDEX `fk_product_type_idx` (`product_type` ASC) ,
  CONSTRAINT `fk_product_category`
    FOREIGN KEY (`product_category` )
    REFERENCES `planetshop_db`.`product_category` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_type`
    FOREIGN KEY (`product_type` )
    REFERENCES `planetshop_db`.`product_type` (`type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `planetshop_db`.`product_attribute`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `planetshop_db`.`product_attribute` (
  `attribute_id` INT NOT NULL AUTO_INCREMENT ,
  `product_type_id` INT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` TEXT NULL ,
  `value_range` VARCHAR(45) NULL ,
  PRIMARY KEY (`attribute_id`) ,
  INDEX `fk_product_type_idx` (`product_type_id` ASC) ,
  CONSTRAINT `fk_attr_product_type`
    FOREIGN KEY (`product_type_id` )
    REFERENCES `planetshop_db`.`product_type` (`type_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  `custom_attribute_id` INT NULL ,
  `custom_attribute_value` VARCHAR(45) NULL ,
  PRIMARY KEY (`order_id`, `product_id`) ,
  INDEX `fk_product_idx` (`product_id` ASC) ,
  INDEX `fk_attr_id_idx` (`custom_attribute_id` ASC) ,
  CONSTRAINT `fk_product`
    FOREIGN KEY (`product_id` )
    REFERENCES `planetshop_db`.`product` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order`
    FOREIGN KEY (`order_id` )
    REFERENCES `planetshop_db`.`order` (`order_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attr_id`
    FOREIGN KEY (`custom_attribute_id` )
    REFERENCES `planetshop_db`.`product_attribute` (`attribute_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `planetshop_db` ;

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `planetshop_db`.* TO 'planetshop_user';

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
-- Data for table `planetshop_db`.`product_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product_type` (`type_id`, `name`) VALUES (1, 'Predefined');
INSERT INTO `planetshop_db`.`product_type` (`type_id`, `name`) VALUES (2, 'Custom planet - Terrestrial');
INSERT INTO `planetshop_db`.`product_type` (`type_id`, `name`) VALUES (3, 'Custom planet - Fluid');
INSERT INTO `planetshop_db`.`product_type` (`type_id`, `name`) VALUES (4, 'Nebulae');
INSERT INTO `planetshop_db`.`product_type` (`type_id`, `name`) VALUES (5, 'Planet Ring');

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (1, 1, 1, 'Terrestrial Planet N39482', 'A super planet for the planetary beginner!', NULL, 10000000.00, 3, 28);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (2, 1, 1, 'Desert Planet', 'The cheaper alternative', NULL, 6000000.00, 3, 5);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (3, 1, 1, 'Ice Planet', 'A planet where vegetation is not necessary', NULL, 8000000.00, 4, 12);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (4, 1, 1, 'Lava Planet', 'A hot planet!', NULL, 7000000.00, 3, 4);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (5, 1, 1, 'Ocean Planet', 'For everyone fond of dolphins', NULL, 12000000.00, 5, 3);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (6, 1, 1, 'Gas Planet', 'Something lighter...', NULL, 4000000.00, 3, 38);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (7, 1, 2, 'Planet #329-234-907', 'Used! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nisl nulla, posuere nec nibh sed, vestibulum porttitor sed.', NULL, 2200000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (9, 1, 2, 'Planet #808-837-666', 'Used!', NULL, 6660000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (10, 1, 2, 'Planet #000-029-203', 'Used', NULL, 9600000.00, 3, 1);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (11, 2, 3, 'Custom terrestrial planet', 'The planet just for you!', NULL, NULL, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (12, 3, 3, 'Custom ocean planet', 'Made just for you!', NULL, NULL, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (13, 3, 3, 'Custom gas planet', 'Tailored', NULL, NULL, 10, 100);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (14, 1, 4, 'Regular moon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel hendrerit lorem. Cras malesuada, justo a ultrices ullamcorper, dui lorem tempor lacus, eu aliquet dui metus at diam. Nulla scelerisque ullamcorper hendrerit. Curabitur ante nisi, vehicula vitae tincidunt non, molestie convallis libero. Sed quis velit sapien. Sed pulvinar turpis vel turpis ornare vehicula. Nullam et ante vel magna pellentesque posuere. Maecenas lacus enim, facilisis at tincidunt in, lobortis eleifend neque. Aliquam massa libero, mattis vitae dui nec, tincidunt feugiat nisl.\n\nUt vel lobortis enim. Donec vehicula libero vitae libero congue, a imperdiet odio tempor. Morbi sagittis nulla in nisl vestibulum tempus ut sit amet elit. Vivamus feugiat tortor nisl. Suspendisse ornare viverra est tempus dictum. Duis nec purus mi. Aenean.', NULL, 2000000, 5, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (15, 1, 4, 'Asteroid moon', 'An awesome asteroid moon. But to be honest, we do not exactly know the difference between this asteroid moon and the regular moon. We guess this one is just a little bit fancier or something. At least it costs a bit more...', NULL, 3000000, 4, 11);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (16, 1, 4, 'Ice moon', 'A really cold moon for those that like it cool.', NULL, 1500000, 5, 4);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (17, 1, 4, 'Trojan', 'Also with this one, we have no freaking idea what this is', NULL, 200000, 10, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (18, 1, 5, 'Meteor field', 'A simple meteor field', NULL, 500000, 5, 16);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (19, 4, 5, 'Nebula', 'A nebulous nebula, available in multiple colors.', NULL, 15000000, 19, 2);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (20, 5, 5, 'Planet ring', 'Planetary rings available in multiple sizes', NULL, 1000000, 5, 10);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (21, 1, 5, 'Meteorite insurance', 'Insurance against meteorite showers', NULL, 50000000, 5, 1000);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (22, 1, 5, 'Supernova', 'Big Boom! But takes 5 weeks to deliver', NULL, 500000000, 25, 2);
INSERT INTO `planetshop_db`.`product` (`product_id`, `product_type`, `product_category`, `name`, `description`, `product_picture`, `price`, `delivery_days`, `inventory_quantity`) VALUES (23, 1, 5, 'Comet', 'A comet that may or may not stay within orbit around a planet', NULL, 100000, 2, 493);

COMMIT;

-- -----------------------------------------------------
-- Data for table `planetshop_db`.`product_attribute`
-- -----------------------------------------------------
START TRANSACTION;
USE `planetshop_db`;
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (1, 1, 'Radius', 'The radius of the planet', '1...10');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (2, 1, 'Surface', 'Surface type', 'Terrestrial (Ice), Terrestrial (Land), Terrestrial (Land/Water),Fluid,Gas,');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (3, 1, 'Mass', 'Mass of the planet', '10...100');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (4, 1, 'Axial tilt', 'The axial tilt in degrees', '0.1...10');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (5, 1, 'Average temperature', 'Temperature of the surface (determined by the distance from the next sun)', '-273...10000');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (6, 2, 'Radius', 'The radius of the planet', NULL);
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (7, 2, 'Surface', 'Surface type', 'Ice,Land,Land/Water');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (8, 2, 'Mass', 'Mass of the planet', '10...100');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (9, 2, 'Axial tilt', 'The axial tilt in degrees', '0.1...10');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (10, 2, 'Average temperature', 'Temperature of the surface (determined by the distance from the next sun)', '-273...10000');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (11, 3, 'Radius', 'The radius of the planet', NULL);
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (12, 3, 'Surface', 'Surface type', 'Water,Hydrogen,Helium');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (13, 3, 'Mass', 'Mass of the planet', '10...100');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (14, 3, 'Axial tilt', 'The axial tilt in degrees', '0.1...10');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (15, 3, 'Average temperature', 'Temperature of the surface (determined by the distance from the next sun)', '-273...10000');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (16, 4, 'Color', 'Color of the nebula', 'Multicolor,Red,Green,Yellow,Blue,Random');
INSERT INTO `planetshop_db`.`product_attribute` (`attribute_id`, `product_type_id`, `name`, `description`, `value_range`) VALUES (17, 5, 'Ring size', 'Size of the planetary ring', 'Extra small,Small,Medium,Large,Extra Large');

COMMIT;
