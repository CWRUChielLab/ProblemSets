CREATE TABLE IF NOT EXISTS /*_*/problemset_question (
  `problemset_id` int(10) NOT NULL,
  `question_number` int(10) NOT NULL,
  `points` double NOT NULL,
  `prompt` text NOT NULL,
  `answer` double NOT NULL,
  `tolerance` double NOT NULL,
  PRIMARY KEY (`problemset_id`,`question_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

