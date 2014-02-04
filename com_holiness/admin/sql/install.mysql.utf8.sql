CREATE TABLE IF NOT EXISTS `#__hpmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `imgext` varchar(4) NOT NULL,
  `title` varchar(6) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `church` varchar(200) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `#__users` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__devotions` (
  `id` int(11) NOT NULL auto_increment,
  `memberid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `theme` varchar(100) NOT NULL,
  `scripture` varchar(60) NOT NULL,
  `reading` text NOT NULL,
  `bible` varchar(60) NOT NULL default '',
  `devotion` text NOT NULL,
  `prayer` text NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
   PRIMARY KEY  (`id`),
   FOREIGN KEY (`userid`) REFERENCES `#__users`(`id`),
   FOREIGN KEY (`memberid`) REFERENCES `#__hpmembers`(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hp_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `post_type` varchar(64) NOT NULL,
  `name` varchar(200) NOT NULL,
  `txt` text,
  `amens` tinytext NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usl1i_users` (`userid`),
  KEY `usl1i_devotions` (`postid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hp_plusone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `post_type` varchar(16) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hp_prayerrequest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `prayed` int(1) NOT NULL DEFAULT '0',
  `flag` int(1) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hp_timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `post_type` varchar(16) NOT NULL,
  `post` varchar(150) NOT NULL,
  `comment_count` int(7) NOT NULL DEFAULT '0',
  `amen_count` int(7) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__devotion_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `devotionid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `txt` text,
  `amens` tinytext NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usl1i_users` (`userid`),
  KEY `usl1i_devotions` (`devotionid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__devotion_partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `partnerid` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `partnerid` (`partnerid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
