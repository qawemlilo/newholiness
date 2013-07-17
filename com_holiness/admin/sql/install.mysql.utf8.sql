CREATE TABLE IF NOT EXISTS `#__devotions` (
  `id` int(11) NOT NULL auto_increment,
  `dt` varchar(100) NOT NULL,
  `pastor` int(11) NOT NULL,
  `theme` varchar(100) NOT NULL,
  `scripture` varchar(60) NOT NULL,
  `reading` text NOT NULL,
  `bible` varchar(60) NOT NULL default '',
  `devotion` text NOT NULL,
  `prayer` text NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__pastors` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `url` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL,
  `church` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__devotion_comments` (
  `id` int(11) NOT NULL auto_increment,
  `devotionid` int(11) NOT NULL,
  `url` varchar(10) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `ts` datetime NOT NULL,
  `comment_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__blessings` (
  `id` int(11) NOT NULL auto_increment,
  `devotionid` int(11) NOT NULL,
  `pastorid` int(11) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__partners` (
  `id` int(11) NOT NULL auto_increment,
  `firstpartner` int(11) NOT NULL,
  `secondpartner` int(11) NOT NULL,
  `active` int(2) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

