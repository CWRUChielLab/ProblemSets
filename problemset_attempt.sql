CREATE TABLE IF NOT EXISTS /*_*/problemset_attempt (
  `attempt_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `problemset_id` int(10) NOT NULL,
  `time_generated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rand_0` double NOT NULL,
  `rand_1` double NOT NULL,
  `rand_2` double NOT NULL,
  `rand_3` double NOT NULL,
  `rand_4` double NOT NULL,
  `rand_5` double NOT NULL,
  `rand_6` double NOT NULL,
  `rand_7` double NOT NULL,
  `rand_8` double NOT NULL,
  `rand_9` double NOT NULL,
  PRIMARY KEY (`attempt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

