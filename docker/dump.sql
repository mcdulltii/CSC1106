CREATE TABLE `users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `form` (
  `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `form_style_id` INT UNSIGNED NOT NULL,
  `form_blob` TEXT NOT NULL,
  PRIMARY KEY (`form_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
