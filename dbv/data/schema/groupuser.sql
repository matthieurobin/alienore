CREATE TABLE `groupuser` (
  `idGroup` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idGroup`,`idUser`),
  KEY `FK_GROUPUSER_idUser` (`idUser`),
  CONSTRAINT `FK_GROUPUSER_idGroup` FOREIGN KEY (`idGroup`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_GROUPUSER_idUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8