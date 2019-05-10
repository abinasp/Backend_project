CREATE TABLE users(
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(256) DEFAULT '',
	`username` VARCHAR(256) NOT NULL UNIQUE,
	`password` VARCHAR(256) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`id`)	
);

CREATE TABLE customers(
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	`account_number` VARCHAR(256) DEFAULT '',
	`name` VARCHAR(256) DEFAULT '',
	`father_name` VARCHAR(256) DEFAULT '',
	`address` text,
	`mobile` VARCHAR(256) DEFAULT '',
	`national_id` VARCHAR(256) DEFAULT '',
	`type` ENUM('Monthly','One time', 'Daily');
	`amount` VARCHAR(256) DEFAULT '',
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
);