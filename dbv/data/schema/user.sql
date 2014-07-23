CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userdate` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  `hash` text NOT NULL,
  `language` varchar(10) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8