CREATE TABLE IF NOT EXISTS /*_*/problemset_response (
  `attempt_id` int(10) NOT NULL,
  `question_number` int(10) NOT NULL,
  `response` double NOT NULL,
  `time_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attempt_id`,`question_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

