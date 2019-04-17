create database bootstrapslim_db ;

use bootstrapslim_db ;

CREATE TABLE `users` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`surname` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`phone` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`is_active` TINYINT(1) NOT NULL,
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `users_email_unique` (`email`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `queue_jobs` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`subject` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`body` LONGTEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`is_sent` TINYINT(4) NULL DEFAULT NULL,
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `queue_job_user_id_foreign` (`user_id`),
	CONSTRAINT `queue_job_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

