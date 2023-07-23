CREATE TABLE `user` (
  `user_id` VARCHAR(255) NOT NULL,
  `user_name` VARCHAR(255) NOT NULL,
  `user_password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `form` (
  `form_id` VARCHAR(255) NOT NULL,
  `form_blob` TEXT NOT NULL,
  `user_id` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`form_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

