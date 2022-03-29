CREATE TABLE IF NOT EXISTS `likes` (
`ID` bigint(20) NOT NULL AUTO_INCREMENT,
`type` varchar(10) NOT NULL,
`contentID` bigint(20) NOT NULL,
`likes` text NOT NULL,
PRIMARY KEY (`ID`),
KEY `contentID` (`contentID`),
KEY `type` (`type`)
);