CREATE TABLE IF NOT EXISTS `usl1i_devotions` (
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
   KEY `usl1i_hpmembers` (`memberid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;