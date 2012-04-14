
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- pc_user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_user`;


CREATE TABLE `pc_user`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(25)  NOT NULL,
	`email` VARCHAR(80)  NOT NULL,
	`encrypted_password` VARCHAR(40)  NOT NULL,
	`salt` VARCHAR(12)  NOT NULL COMMENT 'for strengthening of password',
	`date_format` TINYINT(2) UNSIGNED default 0 COMMENT '0->Y-m-d, 3->d-m-Y, 4->m-d-Y',
	`time_format` TINYINT(2) UNSIGNED default 0 COMMENT '0->5:00pm, 1->17:00',
	`timezone_id` TINYINT UNSIGNED,
	`week_start` TINYINT(2) UNSIGNED default 0 COMMENT '0->Sunday, 1->Monday',
	`dst_active` TINYINT(1) default 0,
	`awaiting_activation` TINYINT(1) default 1,
	`newsletter` TINYINT(1) default 0,
	`forum_id` INTEGER UNSIGNED COMMENT 'it\'s the corresponding id in the forum_users table',
	`last_login` DATETIME,
	`language` VARCHAR(8) default '' COMMENT 'comes from the user agent accept language',
	`preferred_language` VARCHAR(2) default '' COMMENT 'standard 2-char language abbreviation',
	`ip_address` VARCHAR(15) default '',
	`has_desktop_app_been_loaded` TINYINT(1) default 0,
	`has_requested_free_trial` TINYINT(1) default 0,
	`avatar_random_suffix` VARCHAR(32) default '',
	`reminders_active` TINYINT(1) default 0,
	`unsubscribed` TINYINT(1) default 0,
	`latest_blog_access` DATETIME,
	`latest_backup_request` DATETIME,
	`latest_import_request` DATETIME,
	`latest_breaking_news_closed` SMALLINT UNSIGNED,
	`last_promotional_code_inserted` VARCHAR(25) default '' NOT NULL COMMENT 'the user hasn\'t necessarily used it',
	`blocked` TINYINT(1) default 0,
	`session_entry_point` VARCHAR(128) default '',
	`session_referral` VARCHAR(128) default '',
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_user_U_1` (`email`),
	KEY `pc_user_I_1`(`forum_id`),
	INDEX `pc_user_FI_1` (`timezone_id`),
	CONSTRAINT `pc_user_FK_1`
		FOREIGN KEY (`timezone_id`)
		REFERENCES `pc_timezone` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_rememberme_key
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_rememberme_key`;


CREATE TABLE `pc_rememberme_key`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`rememberme_key` VARCHAR(32),
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_rememberme_key_U_1` (`rememberme_key`),
	KEY `pc_rememberme_key_I_1`(`user_id`),
	CONSTRAINT `pc_rememberme_key_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_dirty_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_dirty_task`;


CREATE TABLE `pc_dirty_task`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`task_id` INTEGER UNSIGNED  NOT NULL,
	PRIMARY KEY (`user_id`,`task_id`),
	CONSTRAINT `pc_dirty_task_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`),
	INDEX `pc_dirty_task_FI_2` (`task_id`),
	CONSTRAINT `pc_dirty_task_FK_2`
		FOREIGN KEY (`task_id`)
		REFERENCES `pc_task` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_failed_logins
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_failed_logins`;


CREATE TABLE `pc_failed_logins`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`times` TINYINT UNSIGNED  NOT NULL,
	`updated_at` DATETIME,
	PRIMARY KEY (`user_id`),
	CONSTRAINT `pc_failed_logins_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_activation_token
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_activation_token`;


CREATE TABLE `pc_activation_token`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`token` VARCHAR(16)  NOT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `pc_activation_token_U_1` (`token`),
	CONSTRAINT `pc_activation_token_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_counter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_counter`;


CREATE TABLE `pc_counter`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(31),
	`value` INTEGER UNSIGNED,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_password_reset_token
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_password_reset_token`;


CREATE TABLE `pc_password_reset_token`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`token` VARCHAR(16)  NOT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `pc_password_reset_token_U_1` (`token`),
	CONSTRAINT `pc_password_reset_token_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_plancake_email_address
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_plancake_email_address`;


CREATE TABLE `pc_plancake_email_address`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`email` VARCHAR(63)  NOT NULL COMMENT 'the domain @plancakebox.com is omitted',
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `pc_plancake_email_address_U_1` (`email`),
	KEY `pc_plancake_email_address_I_1`(`email`),
	CONSTRAINT `pc_plancake_email_address_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_list
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_list`;


CREATE TABLE `pc_list`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`sort_order` SMALLINT UNSIGNED default 0,
	`is_header` TINYINT(1) default 0 NOT NULL,
	`is_inbox` TINYINT(1) default 0 NOT NULL,
	`is_todo` TINYINT(1) default 0 NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `pc_list_I_1`(`creator_id`, `sort_order`),
	CONSTRAINT `pc_list_FK_1`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_task`;


CREATE TABLE `pc_task`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`list_id` INTEGER UNSIGNED  NOT NULL,
	`description` VARCHAR(255)  NOT NULL,
	`sort_order` SMALLINT default 0,
	`due_date` DATE,
	`due_time` SMALLINT UNSIGNED,
	`repetition_id` TINYINT UNSIGNED,
	`repetition_param` TINYINT UNSIGNED default 0,
	`is_starred` TINYINT(1) default 0,
	`is_completed` TINYINT(1) default 0 NOT NULL,
	`is_header` TINYINT(1) default 0 NOT NULL,
	`is_from_system` TINYINT(1) default 0 NOT NULL,
	`special_flag` TINYINT UNSIGNED,
	`note` TEXT,
	`contexts` VARCHAR(127) default '' COMMENT 'it is a comma separated list',
	`contact_id` INTEGER UNSIGNED,
	`completed_at` DATETIME,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `pc_task_I_1`(`list_id`, `is_completed`, `due_date`, `sort_order`),
	CONSTRAINT `pc_task_FK_1`
		FOREIGN KEY (`list_id`)
		REFERENCES `pc_list` (`id`),
	INDEX `pc_task_FI_2` (`repetition_id`),
	CONSTRAINT `pc_task_FK_2`
		FOREIGN KEY (`repetition_id`)
		REFERENCES `pc_repetition` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_timezone
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_timezone`;


CREATE TABLE `pc_timezone`
(
	`id` TINYINT UNSIGNED  NOT NULL,
	`label` VARCHAR(8)  NOT NULL COMMENT 'the second part of the label says whether those countries observe DST at all',
	`description` VARCHAR(127)  NOT NULL,
	`offset` SMALLINT SIGNED default 0 COMMENT 'in minutes from UTC',
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_timezone_U_1` (`label`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_users_lists
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_users_lists`;


CREATE TABLE `pc_users_lists`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`list_id` INTEGER UNSIGNED  NOT NULL,
	PRIMARY KEY (`user_id`,`list_id`),
	CONSTRAINT `pc_users_lists_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`),
	INDEX `pc_users_lists_FI_2` (`list_id`),
	CONSTRAINT `pc_users_lists_FK_2`
		FOREIGN KEY (`list_id`)
		REFERENCES `pc_list` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_session
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_session`;


CREATE TABLE `pc_session`
(
	`id` VARCHAR(64)  NOT NULL,
	`data` TEXT,
	`time` INTEGER UNSIGNED,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_watchdog
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_watchdog`;


CREATE TABLE `pc_watchdog`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(16)  NOT NULL,
	`description` TEXT,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_email_change_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_email_change_history`;


CREATE TABLE `pc_email_change_history`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`old_email` VARCHAR(80)  NOT NULL,
	`new_email` VARCHAR(80)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`user_id`),
	INDEX `pc_email_change_history_FI_1` (`user_id`),
	CONSTRAINT `pc_email_change_history_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_users_contexts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_users_contexts`;


CREATE TABLE `pc_users_contexts`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`context` VARCHAR(31)  NOT NULL,
	`sort_order` SMALLINT UNSIGNED default 0,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_users_contexts_FI_1` (`user_id`),
	CONSTRAINT `pc_users_contexts_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_tasks_contexts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_tasks_contexts`;


CREATE TABLE `pc_tasks_contexts`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`task_id` INTEGER UNSIGNED  NOT NULL,
	`users_contexts_id` INTEGER UNSIGNED  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_tasks_contexts_FI_1` (`users_contexts_id`),
	CONSTRAINT `pc_tasks_contexts_FK_1`
		FOREIGN KEY (`users_contexts_id`)
		REFERENCES `pc_users_contexts` (`id`)
		ON DELETE CASCADE,
	INDEX `pc_tasks_contexts_FI_2` (`task_id`),
	CONSTRAINT `pc_tasks_contexts_FK_2`
		FOREIGN KEY (`task_id`)
		REFERENCES `pc_task` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_repetition
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_repetition`;


CREATE TABLE `pc_repetition`
(
	`id` TINYINT UNSIGNED  NOT NULL,
	`human_expression` VARCHAR(63)  NOT NULL,
	`computer_expression` VARCHAR(63)  NOT NULL COMMENT 'a PHP strtostring compatible expression',
	`initial_computer_expression` VARCHAR(63)  NOT NULL COMMENT 'a PHP strtostring compatible expression',
	`special` VARCHAR(16)  NOT NULL COMMENT 'whether it is a special case, as for many weekdays',
	`needs_param` TINYINT(1) default 0 COMMENT 'whether the expression needs a numerical parameter',
	`is_param_cardinal` TINYINT(1) default 0,
	`min_param` TINYINT UNSIGNED default 0,
	`max_param` TINYINT UNSIGNED default 0,
	`sort_order` TINYINT UNSIGNED default 0,
	`has_divider_below` TINYINT(1) default 0 COMMENT 'says whether to add a divider below in a combo box',
	`ical_rrule` VARCHAR(63)  NOT NULL,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_repetition_U_1` (`human_expression`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_value
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_value`;


CREATE TABLE `pc_value`
(
	`name` VARCHAR(32)  NOT NULL,
	`value` TEXT,
	PRIMARY KEY (`name`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_update
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_update`;


CREATE TABLE `pc_update`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`signature` VARCHAR(32)  NOT NULL COMMENT 'important to send the update to the Plancake installations',
	`description` VARCHAR(512)  NOT NULL,
	`url` VARCHAR(128)  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_update_U_1` (`signature`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_donation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_donation`;


CREATE TABLE `pc_donation`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL COMMENT 'can be zero if the user is not logged in',
	`before_donation` TINYINT(1) default 1 COMMENT '1->the user is in the page where to choose the amount; 0->the user has done the donation',
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_supporter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_supporter`;


CREATE TABLE `pc_supporter`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`expiry_date` DATE,
	`is_renewal_automatic` TINYINT(1) default 0,
	PRIMARY KEY (`user_id`),
	CONSTRAINT `pc_supporter_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_blog_post
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_blog_post`;


CREATE TABLE `pc_blog_post`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`slug` VARCHAR(255)  NOT NULL,
	`content` TEXT,
	`italian_url` TEXT,
	`is_reviewed` TINYINT(1) default 0,
	`is_published` TINYINT(1) default 0,
	`published_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pc_blog_post_FI_1` (`user_id`),
	CONSTRAINT `pc_blog_post_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_blog_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_blog_category`;


CREATE TABLE `pc_blog_category`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`name` VARCHAR(64)  NOT NULL,
	`slug` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_blog_categories_posts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_blog_categories_posts`;


CREATE TABLE `pc_blog_categories_posts`
(
	`post_id` INTEGER UNSIGNED  NOT NULL,
	`category_id` INTEGER UNSIGNED  NOT NULL,
	PRIMARY KEY (`post_id`,`category_id`),
	CONSTRAINT `pc_blog_categories_posts_FK_1`
		FOREIGN KEY (`post_id`)
		REFERENCES `pc_blog_post` (`id`),
	INDEX `pc_blog_categories_posts_FI_2` (`category_id`),
	CONSTRAINT `pc_blog_categories_posts_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `pc_blog_category` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_blog_comment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_blog_comment`;


CREATE TABLE `pc_blog_comment`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`post_id` INTEGER UNSIGNED  NOT NULL,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`content` TEXT,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pc_blog_comment_FI_1` (`post_id`),
	CONSTRAINT `pc_blog_comment_FK_1`
		FOREIGN KEY (`post_id`)
		REFERENCES `pc_blog_post` (`id`),
	INDEX `pc_blog_comment_FI_2` (`user_id`),
	CONSTRAINT `pc_blog_comment_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_api_app
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_api_app`;


CREATE TABLE `pc_api_app`
(
	`id` SMALLINT UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64)  NOT NULL,
	`api_key` VARCHAR(40)  NOT NULL,
	`api_secret` VARCHAR(16)  NOT NULL,
	`user_id` INTEGER UNSIGNED,
	`is_limited` TINYINT(1) default 0,
	`description` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_api_app_U_1` (`api_key`),
	KEY `pc_api_app_I_1`(`api_key`),
	INDEX `pc_api_app_FI_1` (`user_id`),
	CONSTRAINT `pc_api_app_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_api_app_stats
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_api_app_stats`;


CREATE TABLE `pc_api_app_stats`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`api_app_id` SMALLINT UNSIGNED,
	`number_of_requests` INTEGER UNSIGNED default 0,
	`bandwidth` INTEGER UNSIGNED default 0 COMMENT 'download bw, in bytes',
	`today` VARCHAR(10),
	`number_of_requests_today` MEDIUMINT UNSIGNED default 0,
	`bandwidth_today` MEDIUMINT UNSIGNED default 0 COMMENT 'download bw, in bytes',
	`last_hour` INTEGER(2),
	`number_of_requests_last_hour` SMALLINT UNSIGNED default 0,
	`bandwidth_last_hour` MEDIUMINT UNSIGNED default 0 COMMENT 'download bw, in bytes',
	PRIMARY KEY (`id`),
	KEY `pc_api_app_stats_I_1`(`api_app_id`),
	CONSTRAINT `pc_api_app_stats_FK_1`
		FOREIGN KEY (`api_app_id`)
		REFERENCES `pc_api_app` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_api_token
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_api_token`;


CREATE TABLE `pc_api_token`
(
	`token` VARCHAR(41)  NOT NULL,
	`api_app_id` SMALLINT UNSIGNED  NOT NULL,
	`user_id` INTEGER UNSIGNED,
	`expiry_timestamp` INTEGER(11),
	PRIMARY KEY (`token`),
	INDEX `pc_api_token_FI_1` (`api_app_id`),
	CONSTRAINT `pc_api_token_FK_1`
		FOREIGN KEY (`api_app_id`)
		REFERENCES `pc_api_app` (`id`),
	INDEX `pc_api_token_FI_2` (`user_id`),
	CONSTRAINT `pc_api_token_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_subscription_thankyou_page_impression
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_subscription_thankyou_page_impression`;


CREATE TABLE `pc_subscription_thankyou_page_impression`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED,
	`username` VARCHAR(25) default '' NOT NULL,
	`email` VARCHAR(80)  NOT NULL,
	`viewed_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_promotion_code
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_promotion_code`;


CREATE TABLE `pc_promotion_code`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(25) default '' NOT NULL,
	`discount_percentage` INTEGER(2)  NOT NULL,
	`expiry_date` DATE  NOT NULL,
	`only_for_new_customers` TINYINT(1) default 0 NOT NULL,
	`uses_count` INTEGER default 0 NOT NULL,
	`max_uses` INTEGER  NOT NULL,
	`note` VARCHAR(512) default '',
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_trashbin_users_contexts
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_trashbin_users_contexts`;


CREATE TABLE `pc_trashbin_users_contexts`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`context` VARCHAR(31)  NOT NULL,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	`deleted_at` INTEGER(11),
	PRIMARY KEY (`id`),
	KEY `pc_trashbin_users_contexts_I_1`(`deleted_at`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_trashbin_list
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_trashbin_list`;


CREATE TABLE `pc_trashbin_list`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`sort_order` SMALLINT UNSIGNED default 0,
	`is_header` TINYINT(1) default 0,
	`is_inbox` TINYINT(1) default 0 NOT NULL,
	`is_todo` TINYINT(1) default 0 NOT NULL,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	`deleted_at` INTEGER(11),
	PRIMARY KEY (`id`),
	KEY `pc_trashbin_list_I_1`(`deleted_at`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_trashbin_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_trashbin_task`;


CREATE TABLE `pc_trashbin_task`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`list_id` INTEGER UNSIGNED  NOT NULL,
	`description` VARCHAR(255)  NOT NULL,
	`sort_order` SMALLINT default 0,
	`due_date` DATE,
	`repetition_id` TINYINT UNSIGNED,
	`repetition_param` TINYINT UNSIGNED default 0,
	`is_completed` TINYINT(1) default 0 NOT NULL,
	`is_header` TINYINT(1) default 0,
	`is_from_system` TINYINT(1) default 0,
	`note` TEXT,
	`contexts` VARCHAR(31) default '' COMMENT 'it is a comma separated list',
	`contact_id` INTEGER UNSIGNED,
	`completed_at` DATETIME,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	`deleted_at` INTEGER(11),
	PRIMARY KEY (`id`),
	KEY `pc_trashbin_task_I_1`(`deleted_at`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_note
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_note`;


CREATE TABLE `pc_note`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`title` VARCHAR(127)  NOT NULL,
	`content` MEDIUMTEXT  NOT NULL,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `pc_note_I_1`(`creator_id`),
	CONSTRAINT `pc_note_FK_1`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_subscription_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_subscription_type`;


CREATE TABLE `pc_subscription_type`
(
	`id` TINYINT(2) UNSIGNED  NOT NULL,
	`name` VARCHAR(32)  NOT NULL,
	`expiration_time_expression` VARCHAR(32)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_paypal_product
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_paypal_product`;


CREATE TABLE `pc_paypal_product`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`item_number` VARCHAR(32)  NOT NULL,
	`item_name` VARCHAR(64)  NOT NULL,
	`item_price` VARCHAR(16)  NOT NULL,
	`item_price_currency` VARCHAR(5)  NOT NULL,
	`discount_percentage` INTEGER UNSIGNED,
	`subscription_type_id` TINYINT(2) UNSIGNED  NOT NULL,
	`paypal_button_code` VARCHAR(32)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_paypal_product_FI_1` (`subscription_type_id`),
	CONSTRAINT `pc_paypal_product_FK_1`
		FOREIGN KEY (`subscription_type_id`)
		REFERENCES `pc_subscription_type` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_paypal_transaction
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_paypal_transaction`;


CREATE TABLE `pc_paypal_transaction`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`item_number` VARCHAR(32) default '' NOT NULL,
	`item_name` VARCHAR(64) default '',
	`custom_field` VARCHAR(127) default '' NOT NULL,
	`payment_status` VARCHAR(32) default '' NOT NULL,
	`payment_amount` VARCHAR(16) default '' NOT NULL,
	`payment_currency` VARCHAR(5) default '' NOT NULL,
	`transaction_id` VARCHAR(64) default '' NOT NULL,
	`parent_transaction_id` VARCHAR(64) default '',
	`receiver_email` VARCHAR(127) default '' NOT NULL,
	`residence_country` VARCHAR(8) default '',
	`payer_email` VARCHAR(127) default '' NOT NULL,
	`payment_date` VARCHAR(32) default '' NOT NULL,
	`error` TINYINT(2) UNSIGNED default 0 COMMENT '0->no error, 1->HTTP error, 2->transaction error, 3->dodgy transaction, 4->duplicate transaction',
	`raw_data` MEDIUMTEXT  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_subscription
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_subscription`;


CREATE TABLE `pc_subscription`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`subscription_type_id` TINYINT(2) UNSIGNED  NOT NULL,
	`was_gift` TINYINT(1) default 0 NOT NULL,
	`was_automatic` TINYINT(1) default 0 NOT NULL,
	`paypal_transaction_id` VARCHAR(64) default '' NOT NULL,
	`is_refunded_or_reversed` TINYINT(1) default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `pc_subscription_I_1`(`user_id`),
	INDEX `pc_subscription_FI_1` (`subscription_type_id`),
	CONSTRAINT `pc_subscription_FK_1`
		FOREIGN KEY (`subscription_type_id`)
		REFERENCES `pc_subscription_type` (`id`),
	CONSTRAINT `pc_subscription_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_quote_of_the_day
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_quote_of_the_day`;


CREATE TABLE `pc_quote_of_the_day`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`quote` VARCHAR(512) default '' NOT NULL,
	`quote_in_italian` VARCHAR(512) default '',
	`quote_author` VARCHAR(64) default '' NOT NULL,
	`quote_author_in_italian` VARCHAR(64) default '',
	`is_tip` TINYINT(1) default 0 COMMENT '0->proper quote, 1->tip from team',
	`shown_on` INTEGER UNSIGNED COMMENT 'YYYYmmdd format',
	PRIMARY KEY (`id`),
	KEY `pc_quote_of_the_day_I_1`(`shown_on`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_google_calendar
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_google_calendar`;


CREATE TABLE `pc_google_calendar`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`calendar_url` VARCHAR(255) default '',
	`session_token` VARCHAR(64) default '' NOT NULL,
	`email_address` VARCHAR(123) default '' NOT NULL,
	`is_active` TINYINT(1) default 0,
	`is_syncing` TINYINT(1) default 0,
	`latest_sync_start_timestamp` INTEGER UNSIGNED,
	`latest_sync_end_timestamp` INTEGER UNSIGNED,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pc_google_calendar_FI_1` (`user_id`),
	CONSTRAINT `pc_google_calendar_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_google_calendar_event
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_google_calendar_event`;


CREATE TABLE `pc_google_calendar_event`
(
	`task_id` INTEGER UNSIGNED  NOT NULL,
	`event_id` VARCHAR(32) default '' NOT NULL,
	`updated_at` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`task_id`),
	KEY `pc_google_calendar_event_I_1`(`event_id`),
	CONSTRAINT `pc_google_calendar_event_FK_1`
		FOREIGN KEY (`task_id`)
		REFERENCES `pc_task` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_archived_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_archived_task`;


CREATE TABLE `pc_archived_task`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`list_id` INTEGER UNSIGNED  NOT NULL,
	`description` VARCHAR(255)  NOT NULL,
	`sort_order` SMALLINT UNSIGNED default 0,
	`due_date` DATE,
	`due_time` SMALLINT UNSIGNED,
	`repetition_id` TINYINT UNSIGNED,
	`repetition_param` TINYINT UNSIGNED default 0,
	`is_starred` TINYINT(1) default 0,
	`is_completed` TINYINT(1) default 0 NOT NULL,
	`is_header` TINYINT(1) default 0 NOT NULL,
	`is_from_system` TINYINT(1) default 0 NOT NULL,
	`special_flag` TINYINT UNSIGNED,
	`note` TEXT,
	`contexts` VARCHAR(31) default '' COMMENT 'it is a comma separated list',
	`completed_at` DATETIME,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_language
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_language`;


CREATE TABLE `pc_language`
(
	`id` CHAR(2)  NOT NULL,
	`name` VARCHAR(32)  NOT NULL,
	`sort_order` SMALLINT SIGNED default 1,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pc_language_U_1` (`name`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_string_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_string_category`;


CREATE TABLE `pc_string_category`
(
	`id` TINYINT UNSIGNED  NOT NULL,
	`name` VARCHAR(64)  NOT NULL,
	`note` VARCHAR(128),
	`link` VARCHAR(128),
	`in_account` TINYINT(1) default 0 NOT NULL,
	`in_misc` TINYINT(1) default 0 NOT NULL,
	`sort_order` MEDIUMINT UNSIGNED  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_string
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_string`;


CREATE TABLE `pc_string`
(
	`id` VARCHAR(64)  NOT NULL,
	`category_id` TINYINT UNSIGNED  NOT NULL,
	`sort_order_in_category` MEDIUMINT UNSIGNED  NOT NULL,
	`max_length` SMALLINT UNSIGNED default 0 NOT NULL,
	`note` VARCHAR(128),
	`is_archived` TINYINT(1) default 0 NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pc_string_FI_1` (`category_id`),
	CONSTRAINT `pc_string_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `pc_string_category` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_translation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_translation`;


CREATE TABLE `pc_translation`
(
	`language_id` CHAR(2)  NOT NULL,
	`string_id` VARCHAR(64)  NOT NULL,
	`string` TEXT  NOT NULL,
	`updated_at` DATETIME,
	PRIMARY KEY (`language_id`,`string_id`),
	CONSTRAINT `pc_translation_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `pc_language` (`id`)
		ON DELETE CASCADE,
	INDEX `pc_translation_FI_2` (`string_id`),
	CONSTRAINT `pc_translation_FK_2`
		FOREIGN KEY (`string_id`)
		REFERENCES `pc_string` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_translator
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_translator`;


CREATE TABLE `pc_translator`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`language_id` CHAR(2)  NOT NULL,
	`has_accepted_agreement` TINYINT(1) default 0 NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`user_id`),
	INDEX `pc_translator_FI_1` (`language_id`),
	CONSTRAINT `pc_translator_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `pc_language` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_user_key
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_user_key`;


CREATE TABLE `pc_user_key`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`key` VARCHAR(32)  NOT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `pc_user_key_U_1` (`key`),
	KEY `pc_user_key_I_1`(`key`),
	CONSTRAINT `pc_user_key_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_contact
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_contact`;


CREATE TABLE `pc_contact`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`description` TEXT,
	`position` VARCHAR(32),
	`email` VARCHAR(255),
	`phone` VARCHAR(32),
	`website` VARCHAR(255),
	`link` VARCHAR(255),
	`twitter` VARCHAR(64),
	`language` VARCHAR(2)  NOT NULL,
	`company_id` INTEGER UNSIGNED,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_contact_FI_1` (`creator_id`),
	CONSTRAINT `pc_contact_FK_1`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`),
	INDEX `pc_contact_FI_2` (`company_id`),
	CONSTRAINT `pc_contact_FK_2`
		FOREIGN KEY (`company_id`)
		REFERENCES `pc_contact_company` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_contact_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_contact_tag`;


CREATE TABLE `pc_contact_tag`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_contact_tag_FI_1` (`creator_id`),
	CONSTRAINT `pc_contact_tag_FK_1`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_contacts_tags
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_contacts_tags`;


CREATE TABLE `pc_contacts_tags`
(
	`contact_id` INTEGER UNSIGNED  NOT NULL,
	`tag_id` INTEGER UNSIGNED  NOT NULL,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`contact_id`,`tag_id`),
	CONSTRAINT `pc_contacts_tags_FK_1`
		FOREIGN KEY (`contact_id`)
		REFERENCES `pc_contact` (`id`),
	INDEX `pc_contacts_tags_FI_2` (`tag_id`),
	CONSTRAINT `pc_contacts_tags_FK_2`
		FOREIGN KEY (`tag_id`)
		REFERENCES `pc_contact_tag` (`id`),
	INDEX `pc_contacts_tags_FI_3` (`creator_id`),
	CONSTRAINT `pc_contacts_tags_FK_3`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_contact_note
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_contact_note`;


CREATE TABLE `pc_contact_note`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`contact_id` INTEGER UNSIGNED  NOT NULL,
	`content` TEXT  NOT NULL,
	`creator_id` INTEGER UNSIGNED  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_contact_note_FI_1` (`contact_id`),
	CONSTRAINT `pc_contact_note_FK_1`
		FOREIGN KEY (`contact_id`)
		REFERENCES `pc_contact` (`id`),
	INDEX `pc_contact_note_FI_2` (`creator_id`),
	CONSTRAINT `pc_contact_note_FK_2`
		FOREIGN KEY (`creator_id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_contact_company
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_contact_company`;


CREATE TABLE `pc_contact_company`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`email` VARCHAR(255),
	`website` VARCHAR(255),
	`address` VARCHAR(255),
	`note` VARCHAR(255),
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_review
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_review`;


CREATE TABLE `pc_review`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`contact_id` INTEGER UNSIGNED  NOT NULL,
	`link` VARCHAR(255)  NOT NULL,
	`html` TEXT  NOT NULL,
	`language` VARCHAR(2)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_review_FI_1` (`contact_id`),
	CONSTRAINT `pc_review_FK_1`
		FOREIGN KEY (`contact_id`)
		REFERENCES `pc_contact` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_tweet
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_tweet`;


CREATE TABLE `pc_tweet`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`content` VARCHAR(256)  NOT NULL,
	`author` VARCHAR(128)  NOT NULL,
	`link` VARCHAR(255)  NOT NULL,
	`language` VARCHAR(2)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_team_collab_tool_newsletter
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_team_collab_tool_newsletter`;


CREATE TABLE `pc_team_collab_tool_newsletter`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(64),
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_bookkeeping_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_bookkeeping_category`;


CREATE TABLE `pc_bookkeeping_category`
(
	`id` TINYINT(2) UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_bookkeeping_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_bookkeeping_type`;


CREATE TABLE `pc_bookkeeping_type`
(
	`id` TINYINT(2) UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_bookkeeping_payment_method
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_bookkeeping_payment_method`;


CREATE TABLE `pc_bookkeeping_payment_method`
(
	`id` TINYINT(2) UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_bookkeeping_contact
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_bookkeeping_contact`;


CREATE TABLE `pc_bookkeeping_contact`
(
	`id` SMALLINT UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_bookkeeping_entry
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_bookkeeping_entry`;


CREATE TABLE `pc_bookkeeping_entry`
(
	`id` INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	`type_id` TINYINT(2) UNSIGNED  NOT NULL,
	`contact_id` SMALLINT UNSIGNED,
	`amount` FLOAT  NOT NULL,
	`description` VARCHAR(255)  NOT NULL,
	`date` DATE  NOT NULL,
	`vat` VARCHAR(2),
	`category_id` TINYINT(2) UNSIGNED  NOT NULL,
	`payment_method_id` TINYINT(2) UNSIGNED  NOT NULL,
	`ref_number` VARCHAR(255),
	`needs_clarification` TINYINT(1) default 0 NOT NULL,
	`question` VARCHAR(255),
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `pc_bookkeeping_entry_FI_1` (`type_id`),
	CONSTRAINT `pc_bookkeeping_entry_FK_1`
		FOREIGN KEY (`type_id`)
		REFERENCES `pc_bookkeeping_type` (`id`),
	INDEX `pc_bookkeeping_entry_FI_2` (`contact_id`),
	CONSTRAINT `pc_bookkeeping_entry_FK_2`
		FOREIGN KEY (`contact_id`)
		REFERENCES `pc_bookkeeping_contact` (`id`),
	INDEX `pc_bookkeeping_entry_FI_3` (`category_id`),
	CONSTRAINT `pc_bookkeeping_entry_FK_3`
		FOREIGN KEY (`category_id`)
		REFERENCES `pc_bookkeeping_category` (`id`),
	INDEX `pc_bookkeeping_entry_FI_4` (`payment_method_id`),
	CONSTRAINT `pc_bookkeeping_entry_FK_4`
		FOREIGN KEY (`payment_method_id`)
		REFERENCES `pc_bookkeeping_payment_method` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_breaking_news
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_breaking_news`;


CREATE TABLE `pc_breaking_news`
(
	`id` SMALLINT UNSIGNED  NOT NULL AUTO_INCREMENT,
	`headline` VARCHAR(256)  NOT NULL,
	`link` VARCHAR(256) default '' NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_hideable_hints_setting
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_hideable_hints_setting`;


CREATE TABLE `pc_hideable_hints_setting`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`inbox` TINYINT(1) default 0 NOT NULL,
	`todo` TINYINT(1) default 0 NOT NULL,
	`completed` TINYINT(1) default 0 NOT NULL,
	`quote` TINYINT(1) default 0 NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `pc_hideable_hints_setting_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `pc_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_testimonial
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_testimonial`;


CREATE TABLE `pc_testimonial`
(
	`id` INTEGER UNSIGNED  NOT NULL,
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`name` VARCHAR(256)  NOT NULL,
	`job_position` VARCHAR(256)  NOT NULL,
	`company` VARCHAR(256),
	`city` VARCHAR(256)  NOT NULL,
	`country` VARCHAR(256)  NOT NULL,
	`comment` TEXT  NOT NULL,
	`photo_link` VARCHAR(256)  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`,`user_id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_email_campaign
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_email_campaign`;


CREATE TABLE `pc_email_campaign`
(
	`id` SMALLINT UNSIGNED  NOT NULL AUTO_INCREMENT,
	`comment` VARCHAR(255)  NOT NULL,
	`email_subject` VARCHAR(255)  NOT NULL,
	`email_body` TEXT  NOT NULL,
	`sql_query` TEXT  NOT NULL,
	`email_addresses` MEDIUMTEXT  NOT NULL,
	`sent_count` INTEGER default 0 NOT NULL,
	`open_count` INTEGER default 0 NOT NULL,
	`email_count` INTEGER  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_split_test
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_split_test`;


CREATE TABLE `pc_split_test`
(
	`id` SMALLINT UNSIGNED  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(128)  NOT NULL,
	`number_of_variants` SMALLINT UNSIGNED  NOT NULL,
	`variants_description` TEXT  NOT NULL,
	`comment` TEXT  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_split_test_result
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_split_test_result`;


CREATE TABLE `pc_split_test_result`
(
	`test_id` SMALLINT UNSIGNED  NOT NULL,
	`variant_id` SMALLINT UNSIGNED  NOT NULL,
	`number_of_tries` INTEGER default 0 NOT NULL,
	`number_of_successes` INTEGER default 0 NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`test_id`,`variant_id`),
	CONSTRAINT `pc_split_test_result_FK_1`
		FOREIGN KEY (`test_id`)
		REFERENCES `pc_split_test` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- pc_split_test_user_result
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc_split_test_user_result`;


CREATE TABLE `pc_split_test_user_result`
(
	`user_id` INTEGER UNSIGNED  NOT NULL,
	`test_id` SMALLINT UNSIGNED  NOT NULL,
	`variant_id` SMALLINT UNSIGNED  NOT NULL,
	`updated_at` DATETIME  NOT NULL,
	PRIMARY KEY (`user_id`,`test_id`,`variant_id`),
	KEY `pc_split_test_user_result_I_1`(`user_id`),
	CONSTRAINT `pc_split_test_user_result_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `pc_user` (`id`),
	INDEX `pc_split_test_user_result_FI_2` (`test_id`),
	CONSTRAINT `pc_split_test_user_result_FK_2`
		FOREIGN KEY (`test_id`)
		REFERENCES `pc_split_test` (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
