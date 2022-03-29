CREATE TABLE IF NOT EXISTS `posts` (
`ID` bigint(19) NOT NULL AUTO_INCREMENT,
`postID` bigint(19) NOT NULL,
`userID` bigint(20) NOT NULL,
`post` varchar(2200) NOT NULL,
`image` varchar(1800) NOT NULL,
`likes` int(11) NOT NULL,
`date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
`hasImage` tinyint(1) NOT NULL,
`isPFP` int(1) NOT NULL,
`isBanner` int(1) NOT NULL,
PRIMARY KEY (`ID`),
KEY `postID` (`postID`),
KEY `userID` (`userID`),
KEY `likes` (`likes`),
KEY `date` (`date`),
KEY `hasImage` (`hasImage`),
FULLTEXT KEY `post` (`post`)
);