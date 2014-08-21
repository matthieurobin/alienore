CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_unique` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8