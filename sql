-- Forms table
CREATE TABLE `test`.`forms` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(500) NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- Form fields table
CREATE TABLE `test`.`form_fields` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `form_id` INT NOT NULL ,
    `name` VARCHAR(500) NOT NULL ,
    `type` VARCHAR(500) NOT NULL ,
    `input_type` VARCHAR(500) NOT NULL ,
    `validation` JSON NOT NULL ,
    `send_email` BOOLEAN NOT NULL ,
    `options` JSON NOT NULL ,
    `order_by` INT NOT NULL ,
    PRIMARY KEY (`id`),
    INDEX `form_id_fk` (`form_id`),
    FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB;

-- Form Submission table
CREATE TABLE `test`.`form_submissions` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `form_id` INT NOT NULL ,
    `data` JSON NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`),
    INDEX `form_id_fk` (`form_id`),
    FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB;