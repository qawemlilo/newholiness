CREATE TABLE IF NOT EXISTS `#__hp_plusone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `post_type` varchar(16) NOT NULL,
  `flag` int(1) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`userid`) REFERENCES `#__users`(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__hp_timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `post_type` varchar(16) NOT NULL,
  `post` varchar(150) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
   PRIMARY KEY  (`id`),
   FOREIGN KEY (`userid`) REFERENCES `#__users`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;