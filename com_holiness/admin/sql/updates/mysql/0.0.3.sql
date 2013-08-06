CREATE TABLE IF NOT EXISTS `#__devotion_partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `partnerid` int(11) NOT NULL,
  `active` int(2) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`userid`) REFERENCES `#__hpmembers`(`id`),
  FOREIGN KEY (`partnerid`) REFERENCES `#__hpmembers`(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;