CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_unique` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `groupuser` (
  `idGroup` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idGroup`,`idUser`),
  KEY `FK_GROUPUSER_idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `groupuser`
  ADD CONSTRAINT `FK_GROUPUSER_idGroup` FOREIGN KEY (`idGroup`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_GROUPUSER_idUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE;