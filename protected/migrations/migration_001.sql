SET foreign_key_checks = 0;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verification_hash` text DEFAULT NULL,
  `password_reset_verification_hash` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) UNIQUE NOT NULL,
  `creator` int(11) NOT NULL,
  `game_state` longtext DEFAULT NULL,
  `game_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  CONSTRAINT `games_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `users_games_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_games_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;