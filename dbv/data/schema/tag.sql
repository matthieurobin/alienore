CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_label` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8