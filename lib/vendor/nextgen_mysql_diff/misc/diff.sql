CREATE TABLE `pc_watchdog2`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`type2` VARCHAR(16)  NOT NULL,
	`description` TEXT,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

DELETE TABLE `pc_watchdog`;

