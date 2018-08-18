CREATE TABLE `master_braintree_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `course_id` int(11) NOT NULL,
  `transaction_id` varchar(64) DEFAULT NULL COMMENT 'braintree transaction id - NULL for unsuccessful transaction attempts',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `main_index` (`user_id`,`course_id`,`transaction_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

ALTER TABLE `master_courses`
ADD COLUMN `price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00 AFTER `course_name`;

