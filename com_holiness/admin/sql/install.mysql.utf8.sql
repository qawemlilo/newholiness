CREATE TABLE IF NOT EXISTS `#__hpmembers` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `imgext` varchar(4) NOT NULL,
  `title` varchar(6) NULL,
  `dob` date NULL,
  `gender` varchar(1) NULL,
  `church` varchar(200) NOT NULL,
   PRIMARY KEY  (`id`),
   KEY `#__users` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;