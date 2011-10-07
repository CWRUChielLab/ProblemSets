CREATE TABLE IF NOT EXISTS /*_*/problemset (
  `problemset_id` int(10) NOT NULL,
  `name` text NOT NULL,
  `max_attempts` int(10) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '1',
  `live` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`problemset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

