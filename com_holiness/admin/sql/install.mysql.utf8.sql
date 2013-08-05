CREATE TABLE IF NOT EXISTS `#__hpmembers` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `imgext` varchar(4) NOT NULL,
  `title` varchar(6) NULL,
  `dob` date NULL,
  `gender` varchar(1) NULL,
  `church` varchar(200) NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
   PRIMARY KEY  (`id`),
   FOREIGN KEY (`userid`) REFERENCES `#__users`(`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__devotions` (
  `id` int(11) NOT NULL auto_increment,
  `memberid` int(11) NOT NULL,
  `theme` varchar(100) NOT NULL,
  `scripture` varchar(60) NOT NULL,
  `reading` text NOT NULL,
  `bible` varchar(60) NOT NULL default '',
  `devotion` text NOT NULL,
  `prayer` text NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
   PRIMARY KEY  (`id`),
   FOREIGN KEY (`memberid`) REFERENCES `#__hpmembers`(`memberid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;