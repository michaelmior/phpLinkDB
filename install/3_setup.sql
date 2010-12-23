--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `linkID` int(11) NOT NULL default '0',
  `IP` int(4) unsigned NOT NULL default '0',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `userID` int(10) unsigned,
  PRIMARY KEY  (`linkID`,`IP`,`time`)
) ENGINE=InnoDB;

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `categoryID` int(10) unsigned NOT NULL,
  `submittedBy` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `description` varchar(500),
  `url` text NOT NULL,
  `dateAdded` datetime NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `outCount` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `userID` int(10) unsigned NOT NULL default '0',
  `linkID` int(10) unsigned NOT NULL default '0',
  `rating` tinyint(1) unsigned default NULL,
  `review` text,
  PRIMARY KEY  (`userID`,`linkID`),
  KEY `linkID` (`linkID`)
) ENGINE=InnoDB;

--
-- Table structure for table `activeUsers`
--

CREATE TABLE activeUsers (
 username varchar(30) primary key,
 timestamp int(11) unsigned not null
);


--
-- Table structure for table `activeGuests`
--

CREATE TABLE activeGuests (
 ip varchar(15) primary key,
 timestamp int(11) unsigned not null
);

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `level` tinyint(4) unsigned default '1',
  `username` varchar(30) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `salt` char(8) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `joinedDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

--
-- Foreign key constraints
--

ALTER TABLE `access` ADD FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);
ALTER TABLE `links` ADD FOREIGN KEY (`categoryID`) REFERENCES `categories` (`ID`);
ALTER TABLE `links` ADD FOREIGN KEY (`submittedBy`) REFERENCES `users` (`ID`);
ALTER TABLE `reviews` ADD FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Search indices
--

ALTER TABLE `links` ADD FULLTEXT (`title`, `description`);

--
-- Article star rating tables
--

CREATE TABLE `ips` (
  `id` int(11) NOT NULL auto_increment,
  `ip` char(25) collate latin1_general_ci default NULL,
  `count` int(5) default NULL,
  `countID` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `results` (
  `id` int(11) NOT NULL default '0',
  `votes` int(11) default NULL,
  `points` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
