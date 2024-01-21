CREATE TABLE IF NOT EXISTS `inventory`.`authorized_tokens` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `token` VARCHAR(150) NOT NULL,
    `status` ENUM('Y', 'N') NOT NULL DEFAULT 'N',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `token_UNIQUE` (`token` ASC)
);

CREATE TABLE IF NOT EXISTS `inventory`.`products` (
    `id` INT(20) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
    `sku` VARCHAR(45) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `description` VARCHAR(256) DEFAULT NULL,
    `amount` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `inventory`.`categories` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `inventory`.`products_categories` (
    `product_id` INT NOT NULL,
    `category_id` INT NOT NULL,
	FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY (`product_id`, `category_id`)
);

INSERT INTO `authorized_tokens` (`token`, `status`) VALUES ('7829fca4-745d-4179-85a3-e9ee3fb656d9', 'Y');

