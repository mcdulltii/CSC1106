CREATE TABLE `users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `form_styles` (
  `form_style_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_html` TEXT NOT NULL,
  `form_css` TEXT NOT NULL,
  PRIMARY KEY (`form_style_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `forms` (
  `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_blob` TEXT NOT NULL,
  PRIMARY KEY (`form_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`form_style_id`) REFERENCES `form_styles`(`form_style_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
