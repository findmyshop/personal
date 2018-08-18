CREATE TABLE `master_url_subdirectories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(256) COLLATE utf8_bin NOT NULL,
  `subdirectory` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url_subdirectory_index` (`url`(255),`subdirectory`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
