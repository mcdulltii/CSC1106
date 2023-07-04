CREATE TABLE `user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NOT NULL,
  `user_password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `form` (
  `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_blob` TEXT NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`form_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

