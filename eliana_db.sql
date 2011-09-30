ALTER TABLE  `tweet_users` ADD  `sex` CHAR( 1 ) NOT NULL AFTER  `last_update` ,
ADD INDEX (  `sex` )