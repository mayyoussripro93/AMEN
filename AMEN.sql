-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `admin_password_resets`;
CREATE TABLE `admin_password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(190) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `admin_password_resets_email_index` (`email`),
  KEY `admin_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `applicant_messages`;
CREATE TABLE `applicant_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `to_email` varchar(100) DEFAULT NULL,
  `to_name` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `from_phone` varchar(20) DEFAULT NULL,
  `message_txt` mediumtext,
  `subject` varchar(200) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `career_levels`;
CREATE TABLE `career_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `career_level_id` int(11) DEFAULT '0',
  `career_level` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT '0',
  `city` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL,
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `cms`;
CREATE TABLE `cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(250) DEFAULT NULL,
  `show_in_top_menu` tinyint(1) DEFAULT '0',
  `show_in_footer_menu` tinyint(1) DEFAULT '0',
  `seo_title` text,
  `seo_description` text,
  `seo_keywords` text,
  `seo_other` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `cms_content`;
CREATE TABLE `cms_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `page_title` text,
  `page_content` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lang` varchar(10) DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `violation_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ceo` varchar(60) DEFAULT NULL,
  `industry_id` int(11) DEFAULT '0',
  `ownership_type_id` int(11) DEFAULT '0',
  `description` mediumtext,
  `location` varchar(155) DEFAULT NULL,
  `no_of_offices` int(11) DEFAULT NULL,
  `website` varchar(155) DEFAULT NULL,
  `no_of_employees` varchar(15) DEFAULT NULL,
  `established_in` varchar(12) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `logo` varchar(155) DEFAULT NULL,
  `country_id` int(11) DEFAULT '0',
  `state_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `slug` varchar(155) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_featured` tinyint(1) DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `map` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `facebook` varchar(250) DEFAULT NULL,
  `twitter` varchar(250) DEFAULT NULL,
  `linkedin` varchar(250) DEFAULT NULL,
  `google_plus` varchar(250) DEFAULT NULL,
  `pinterest` varchar(250) DEFAULT NULL,
  `package_id` int(11) DEFAULT '0',
  `package_start_date` timestamp NULL DEFAULT NULL,
  `package_end_date` timestamp NULL DEFAULT NULL,
  `jobs_quota` int(5) DEFAULT '0',
  `availed_jobs_quota` int(5) DEFAULT '0',
  `is_subscribed` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `company_messages`;
CREATE TABLE `company_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `to_email` varchar(100) DEFAULT NULL,
  `to_name` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `from_phone` varchar(20) DEFAULT NULL,
  `message_txt` mediumtext,
  `subject` varchar(200) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `is_event` tinyint(1) DEFAULT '0',
  `is_mail` tinyint(1) DEFAULT '0',
  `is_replay` tinyint(4) DEFAULT '0',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `company_password_resets`;
CREATE TABLE `company_password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `first_name` text COLLATE utf8mb4_unicode_ci,
  `last_name` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `contact_mail`;
CREATE TABLE `contact_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `email` text,
  `message` mediumtext,
  `subject` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message_txt` mediumtext,
  `subject` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT '0',
  `country` varchar(150) DEFAULT NULL,
  `nationality` varchar(150) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `sort_order` int(11) DEFAULT '9999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `countries_details`;
CREATE TABLE `countries_details` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT '0',
  `sort_name` varchar(5) NOT NULL,
  `phone_code` int(7) NOT NULL,
  `currency` varchar(60) DEFAULT NULL,
  `code` varchar(7) DEFAULT NULL,
  `symbol` varchar(7) DEFAULT NULL,
  `thousand_separator` varchar(2) DEFAULT NULL,
  `decimal_separator` varchar(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `danger_cat`;
CREATE TABLE `danger_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT '0',
  `country` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  `sort_order` int(11) DEFAULT '9999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `danger_sub_cat`;
CREATE TABLE `danger_sub_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) DEFAULT '0',
  `state` text NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `degree_levels`;
CREATE TABLE `degree_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree_level_id` int(11) DEFAULT '0',
  `degree_level` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `degree_types`;
CREATE TABLE `degree_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree_level_id` int(11) DEFAULT '0',
  `degree_type_id` int(11) DEFAULT '0',
  `degree_type` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `national_id_card_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_num` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` text COLLATE utf8mb4_unicode_ci,
  `is_active` int(11) DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_role_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_manager` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `job_employer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_request` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `employee_educations`;
CREATE TABLE `employee_educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `degree_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `date_completion` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_result` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `employee_evaluations`;
CREATE TABLE `employee_evaluations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `evaluation_date` date NOT NULL,
  `performance` varchar(255) DEFAULT NULL,
  `initiative` varchar(255) DEFAULT NULL,
  `collaboration` varchar(255) DEFAULT NULL,
  `participation` varchar(255) DEFAULT NULL,
  `supervisory` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `employee_password_resets`;
CREATE TABLE `employee_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  KEY `employee_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `employee_relations`;
CREATE TABLE `employee_relations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `employee_child_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `employee_roles`;
CREATE TABLE `employee_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_order` int(11) NOT NULL,
  `role_description` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `employee_uploads`;
CREATE TABLE `employee_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_file` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_question` mediumtext,
  `faq_answer` mediumtext,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `favourites_company`;
CREATE TABLE `favourites_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `company_slug` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `favourites_job`;
CREATE TABLE `favourites_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_slug` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `favourite_applicants`;
CREATE TABLE `favourite_applicants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `functional_areas`;
CREATE TABLE `functional_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `functional_area_id` int(11) DEFAULT '0',
  `functional_area` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `genders`;
CREATE TABLE `genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) DEFAULT '0',
  `gender` varchar(30) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `homepage_uploads`;
CREATE TABLE `homepage_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_file` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `industries`;
CREATE TABLE `industries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_id` int(11) DEFAULT '0',
  `industry` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `company_organize_name` varchar(200) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `description` longtext,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `is_freelance` tinyint(1) DEFAULT '0',
  `career_level_id` int(11) DEFAULT NULL,
  `salary_from` int(11) DEFAULT NULL,
  `salary_to` int(11) DEFAULT NULL,
  `hide_salary` tinyint(1) DEFAULT '0',
  `salary_currency` varchar(5) DEFAULT NULL,
  `salary_period_id` int(11) DEFAULT NULL,
  `functional_area_id` int(11) DEFAULT NULL,
  `job_type_id` int(11) DEFAULT NULL,
  `job_shift_id` int(11) DEFAULT NULL,
  `num_of_positions` int(3) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `degree_level_id` int(11) DEFAULT NULL,
  `job_experience_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_featured` tinyint(1) DEFAULT '0',
  `islamic_data` datetime DEFAULT NULL,
  `islamic_data_detail` text,
  `gregorian_data` datetime DEFAULT NULL,
  `gregorian_data_detail` text,
  `islamic_data_to` datetime DEFAULT NULL,
  `islamic_data_detail_to` text,
  `gregorian_data_to` datetime DEFAULT NULL,
  `gregorian_data_detail_to` text,
  `duration_course` text,
  `Initiatives_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `search` text,
  `slug` varchar(210) DEFAULT NULL,
  `logo` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `full_search` (`search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `job_apply`;
CREATE TABLE `job_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `cv_id` int(11) DEFAULT NULL,
  `current_salary` int(11) DEFAULT NULL,
  `expected_salary` int(11) DEFAULT NULL,
  `salary_currency` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `job_experiences`;
CREATE TABLE `job_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_experience_id` int(11) DEFAULT '0',
  `job_experience` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `job_shifts`;
CREATE TABLE `job_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_shift_id` int(11) DEFAULT '0',
  `job_shift` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `job_skills`;
CREATE TABLE `job_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_skill_id` int(11) DEFAULT '0',
  `job_skill` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `job_titles`;
CREATE TABLE `job_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title_id` int(11) DEFAULT '0',
  `job_title` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `job_types`;
CREATE TABLE `job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_type_id` int(11) DEFAULT '0',
  `job_type` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `join_initiatives`;
CREATE TABLE `join_initiatives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(250) DEFAULT NULL,
  `native` varchar(250) DEFAULT NULL,
  `iso_code` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_rtl` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `language_levels`;
CREATE TABLE `language_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_level_id` int(11) DEFAULT '0',
  `language_level` varchar(40) NOT NULL,
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `major_subjects`;
CREATE TABLE `major_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major_subject_id` int(11) DEFAULT '0',
  `major_subject` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `manage_job_skills`;
CREATE TABLE `manage_job_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT '0',
  `job_skill_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `marital_statuses`;
CREATE TABLE `marital_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marital_status_id` int(11) DEFAULT '0',
  `marital_status` varchar(40) NOT NULL,
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `objections`;
CREATE TABLE `objections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `violation_id` int(11) NOT NULL,
  `employee_id_create` int(11) NOT NULL,
  `objection_txt` text NOT NULL,
  `employee_id_reply` int(11) DEFAULT NULL,
  `objection_reply` text,
  `is_accepted` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `violation_id` (`violation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ownership_types`;
CREATE TABLE `ownership_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownership_type_id` int(11) DEFAULT '0',
  `ownership_type` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_title` varchar(150) DEFAULT NULL,
  `package_price` float(7,2) DEFAULT '0.00',
  `package_num_days` int(11) DEFAULT '0',
  `package_num_listings` int(11) DEFAULT '0',
  `package_for` enum('job_seeker','employer') DEFAULT 'job_seeker',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_cvs`;
CREATE TABLE `profile_cvs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `cv_file` varchar(120) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_educations`;
CREATE TABLE `profile_educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `degree_level_id` int(11) DEFAULT NULL,
  `degree_type_id` int(11) DEFAULT NULL,
  `degree_title` varchar(150) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `date_completion` varchar(15) DEFAULT NULL,
  `institution` varchar(150) DEFAULT NULL,
  `degree_result` varchar(20) DEFAULT NULL,
  `result_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_education_major_subjects`;
CREATE TABLE `profile_education_major_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_education_id` int(11) DEFAULT NULL,
  `major_subject_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_experiences`;
CREATE TABLE `profile_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `company` varchar(120) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `date_start` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `date_end` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_currently_working` tinyint(1) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_languages`;
CREATE TABLE `profile_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `language_level_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_projects`;
CREATE TABLE `profile_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(120) DEFAULT NULL,
  `description` text,
  `url` tinytext,
  `date_start` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `date_end` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_on_going` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_skills`;
CREATE TABLE `profile_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_skill_id` int(11) DEFAULT NULL,
  `job_experience_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `profile_summaries`;
CREATE TABLE `profile_summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `summary` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `higri_start_date` date DEFAULT NULL,
  `higri_start_txt` varchar(255) DEFAULT NULL,
  `date_gregorian` date NOT NULL,
  `date_gregorian_txt` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `project_type` varchar(255) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `Traffic_Accidents` varchar(255) DEFAULT NULL,
  `Fire` varchar(255) DEFAULT NULL,
  `Injuries` varchar(255) DEFAULT NULL,
  `Deaths` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `projects_assigns`;
CREATE TABLE `projects_assigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_head_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `project_uploads`;
CREATE TABLE `project_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_file` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `queue_jobs`;
CREATE TABLE `queue_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `report_abuse_company_messages`;
CREATE TABLE `report_abuse_company_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `your_name` varchar(100) DEFAULT NULL,
  `your_email` varchar(100) DEFAULT NULL,
  `company_url` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `report_abuse_messages`;
CREATE TABLE `report_abuse_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `your_name` varchar(100) DEFAULT NULL,
  `your_email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `result_types`;
CREATE TABLE `result_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_type_id` int(11) DEFAULT '0',
  `result_type` varchar(40) NOT NULL,
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_abbreviation` varchar(30) NOT NULL,
  `role_description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `salary_periods`;
CREATE TABLE `salary_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_period_id` int(11) DEFAULT '0',
  `salary_period` varchar(200) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `send_to_friend_messages`;
CREATE TABLE `send_to_friend_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `your_name` varchar(100) DEFAULT NULL,
  `your_email` varchar(100) DEFAULT NULL,
  `job_url` mediumtext,
  `friend_name` varchar(100) DEFAULT NULL,
  `friend_email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `seo`;
CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` text,
  `seo_title` text,
  `seo_description` text,
  `seo_keywords` text,
  `seo_other` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) DEFAULT NULL,
  `site_slogan` varchar(150) DEFAULT NULL,
  `site_logo` varchar(100) DEFAULT NULL,
  `site_phone_primary` varchar(20) DEFAULT NULL,
  `site_phone_secondary` varchar(20) DEFAULT NULL,
  `default_country_id` int(11) DEFAULT NULL,
  `default_currency_code` varchar(4) DEFAULT NULL,
  `site_street_address` varchar(250) DEFAULT NULL,
  `site_google_map` mediumtext,
  `mail_driver` enum('array','log','sparkpost','ses','mandrill','mailgun','sendmail','smtp','mail') DEFAULT 'smtp',
  `mail_host` varchar(100) DEFAULT NULL,
  `mail_port` int(5) DEFAULT NULL,
  `mail_from_address` varchar(100) DEFAULT NULL,
  `mail_from_name` varchar(100) DEFAULT NULL,
  `mail_to_address` varchar(100) DEFAULT NULL,
  `mail_to_name` varchar(100) DEFAULT NULL,
  `mail_encryption` varchar(10) DEFAULT NULL,
  `mail_username` varchar(100) DEFAULT NULL,
  `mail_password` varchar(100) DEFAULT NULL,
  `mail_sendmail` varchar(50) DEFAULT NULL,
  `mail_pretend` varchar(50) DEFAULT NULL,
  `mailgun_domain` varchar(100) DEFAULT NULL,
  `mailgun_secret` varchar(100) DEFAULT NULL,
  `mandrill_secret` varchar(100) DEFAULT NULL,
  `sparkpost_secret` varchar(100) DEFAULT NULL,
  `ses_key` varchar(100) DEFAULT NULL,
  `ses_secret` varchar(100) DEFAULT NULL,
  `ses_region` varchar(100) DEFAULT NULL,
  `facebook_address` text,
  `twitter_address` text,
  `google_plus_address` text,
  `youtube_address` text,
  `instagram_address` text,
  `pinterest_address` text,
  `linkedin_address` text,
  `tumblr_address` text,
  `flickr_address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `index_page_below_top_employes_ad` mediumtext,
  `above_footer_ad` mediumtext,
  `dashboard_page_ad` mediumtext,
  `cms_page_ad` mediumtext,
  `listing_page_vertical_ad` mediumtext,
  `listing_page_horizontal_ad` mediumtext,
  `nocaptcha_sitekey` varchar(150) DEFAULT NULL,
  `nocaptcha_secret` varchar(150) DEFAULT NULL,
  `facebook_app_id` varchar(150) DEFAULT NULL,
  `facebeek_app_secret` varchar(150) DEFAULT NULL,
  `google_app_id` varchar(150) DEFAULT NULL,
  `google_app_secret` varchar(150) DEFAULT NULL,
  `twitter_app_id` varchar(150) DEFAULT NULL,
  `twitter_app_secret` varchar(150) DEFAULT NULL,
  `paypal_account` varchar(250) DEFAULT NULL,
  `paypal_client_id` varchar(250) DEFAULT NULL,
  `paypal_secret` varchar(250) DEFAULT NULL,
  `paypal_live_sandbox` enum('live','sandbox') DEFAULT 'sandbox',
  `stripe_key` varchar(250) DEFAULT NULL,
  `stripe_secret` varchar(250) DEFAULT NULL,
  `bank_details` mediumtext,
  `listing_age` int(3) NOT NULL DEFAULT '15',
  `country_specific_site` tinyint(1) DEFAULT '0',
  `is_paypal_active` tinyint(1) DEFAULT '1',
  `is_bank_transfer_active` tinyint(1) DEFAULT '1',
  `is_jobseeker_package_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_stripe_active` tinyint(1) DEFAULT '1',
  `is_slider_active` tinyint(1) DEFAULT '0',
  `mailchimp_api_key` tinytext,
  `mailchimp_list_name` tinytext,
  `mailchimp_list_id` tinytext,
  `is_company_package_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `site_settings` (`id`, `site_name`, `site_slogan`, `site_logo`, `site_phone_primary`, `site_phone_secondary`, `default_country_id`, `default_currency_code`, `site_street_address`, `site_google_map`, `mail_driver`, `mail_host`, `mail_port`, `mail_from_address`, `mail_from_name`, `mail_to_address`, `mail_to_name`, `mail_encryption`, `mail_username`, `mail_password`, `mail_sendmail`, `mail_pretend`, `mailgun_domain`, `mailgun_secret`, `mandrill_secret`, `sparkpost_secret`, `ses_key`, `ses_secret`, `ses_region`, `facebook_address`, `twitter_address`, `google_plus_address`, `youtube_address`, `instagram_address`, `pinterest_address`, `linkedin_address`, `tumblr_address`, `flickr_address`, `created_at`, `updated_at`, `index_page_below_top_employes_ad`, `above_footer_ad`, `dashboard_page_ad`, `cms_page_ad`, `listing_page_vertical_ad`, `listing_page_horizontal_ad`, `nocaptcha_sitekey`, `nocaptcha_secret`, `facebook_app_id`, `facebeek_app_secret`, `google_app_id`, `google_app_secret`, `twitter_app_id`, `twitter_app_secret`, `paypal_account`, `paypal_client_id`, `paypal_secret`, `paypal_live_sandbox`, `stripe_key`, `stripe_secret`, `bank_details`, `listing_age`, `country_specific_site`, `is_paypal_active`, `is_bank_transfer_active`, `is_jobseeker_package_active`, `is_stripe_active`, `is_slider_active`, `mailchimp_api_key`, `mailchimp_list_name`, `mailchimp_list_id`, `is_company_package_active`) VALUES
(1272,	'Amen',	'لبيئة عمل آمنة',	'amen-1560760006-676.jpg',	'+92 12 1234567',	'+92 12 1234568',	191,	'SAR',	'المملكة العربية السعودية',	'<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14948773.055931786!2d36.020739416092354!3d23.832719511400292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2seg!4v1573392718952!5m2!1sen!2seg\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\"></iframe>',	'smtp',	'smtp.googlemail.com',	465,	'support@amen.com',	'Amen',	'eng.samah1988@gmail.com',	'Amen',	'ssl',	'amen.sa.2019@gmail.com',	'Amen@2019#SA',	'/usr/sbin/sendmail -bs',	'true',	'your-mailgun-domain',	'your-mailgun-secret',	'your-mandrill-secret',	'your-sparkpost-secret',	'your-ses-key',	'your-ses-secret',	'your-ses-region',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-09-24 08:27:10',	'2019-11-11 09:30:38',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'6LfBeDcUAAAAAM0CHcjbl4WVZOirTJI4wGWFxqoK',	'6LfBeDcUAAAAANIVTb1vHuL9-rGZG7qgPe02Jioc',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'jobseeker14business@hotmail.com',	'AWuIi1J_QCuTudnhU3-TKNLYg1GHuGz-y8nsdh5Cosa9rPL7StMKjTdBTahjyOt95_3HPwPKPHZziA9r',	'EOQpru3Ee-topJnnm8fvz70qkS3uQxSynLqGeUZ2l-DG4XW9wEJOELzaMUKfegWFXAE917WYFkkOqiuU',	'sandbox',	'pk_test_qZrL4iEhRiW0xVy1X3HRDtnp',	'sk_test_Jc5YJMkPz81EuYgEy2eGPMdp',	'<h5>Bank Details</h5>\r\n<br />\r\n<p>Lorem ipsum dolor sit amet,<br /><br />consectetur adipiscing elit.</p>\r\n<br />\r\n<p><strong>Account Number:</strong> 123456789130</p>\r\n<br />\r\n<p><strong>Branch Code:</strong> 123456789130</p>\r\n<br />\r\n<p><strong>Bank Name:</strong> Bank of America</p>\r\n<br />\r\n<p><strong>Bank Address:</strong> New York</p>',	15,	0,	1,	1,	0,	1,	1,	'e018ea311537eaa81c2a22e894064f4d-us19',	'subscribers',	'df624b23e2',	1);

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) DEFAULT '0',
  `slider_image` varchar(150) DEFAULT NULL,
  `slider_heading` varchar(250) DEFAULT NULL,
  `slider_description` tinytext,
  `slider_link` tinytext,
  `slider_link_text` varchar(100) DEFAULT NULL,
  `lang` varchar(10) DEFAULT 'en',
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int(5) DEFAULT '99999',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) DEFAULT '0',
  `state` varchar(40) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `is_default` int(1) DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '9999',
  `lang` varchar(10) NOT NULL DEFAULT 'en',
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testimonial_id` int(11) DEFAULT '0',
  `testimonial_by` varchar(100) DEFAULT NULL,
  `testimonial` varchar(600) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender_id` int(2) DEFAULT NULL,
  `marital_status_id` int(2) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `national_id_card_number` varchar(100) DEFAULT NULL,
  `country_id` varchar(50) DEFAULT NULL,
  `state_id` varchar(50) DEFAULT NULL,
  `city_id` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile_num` varchar(25) DEFAULT NULL,
  `job_experience_id` int(2) DEFAULT NULL,
  `career_level_id` int(2) DEFAULT NULL,
  `industry_id` int(2) DEFAULT NULL,
  `functional_area_id` int(2) DEFAULT NULL,
  `current_salary` varchar(100) DEFAULT NULL,
  `expected_salary` varchar(100) DEFAULT NULL,
  `salary_currency` varchar(10) DEFAULT NULL,
  `street_address` tinytext,
  `is_active` int(1) DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `provider` varchar(35) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_immediate_available` tinyint(1) DEFAULT '1',
  `num_profile_views` int(11) DEFAULT '0',
  `package_id` int(11) DEFAULT '0',
  `package_start_date` timestamp NULL DEFAULT NULL,
  `package_end_date` timestamp NULL DEFAULT NULL,
  `jobs_quota` int(5) DEFAULT '0',
  `availed_jobs_quota` int(5) DEFAULT '0',
  `search` text,
  `is_subscribed` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  FULLTEXT KEY `full_search` (`search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `user_messages`;
CREATE TABLE `user_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) DEFAULT NULL,
  `listing_title` varchar(150) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `to_email` varchar(100) DEFAULT NULL,
  `to_name` varchar(100) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `from_phone` varchar(20) DEFAULT NULL,
  `message_txt` mediumtext,
  `subject` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) DEFAULT '0',
  `video_title` tinytext,
  `video_text` text,
  `video_link` text,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT NULL,
  `sort_order` int(5) DEFAULT '99999',
  `lang` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


DROP TABLE IF EXISTS `violations`;
CREATE TABLE `violations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `higri_date` date DEFAULT NULL,
  `higri_txt` varchar(255) DEFAULT NULL,
  `gregorian_txt` varchar(255) DEFAULT NULL,
  `gregorian_date` date DEFAULT NULL,
  `violation_time` time DEFAULT NULL,
  `axles` varchar(255) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `special_marque` varchar(255) NOT NULL,
  `danger_cat_id` int(11) NOT NULL,
  `danger_sub_cat_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `danger_status` varchar(255) NOT NULL,
  `removement_duration` date DEFAULT NULL,
  `payment_status` tinyint(4) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `current_cost` float DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `danger_status_last` varchar(255) DEFAULT NULL,
  `area_status_last` varchar(255) DEFAULT NULL,
  `objection_status` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `violation_history`;
CREATE TABLE `violation_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `violation_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `cost` float DEFAULT NULL,
  `danger_status` varchar(255) NOT NULL,
  `removement_duration` date DEFAULT NULL,
  `area_status` varchar(255) NOT NULL,
  `notes` text,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `violation_uploads`;
CREATE TABLE `violation_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `violation_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_file` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2020-02-10 15:20:59
