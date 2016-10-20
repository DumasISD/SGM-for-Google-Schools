--
-- Table structure for table `smart_groups`
--

DROP TABLE IF EXISTS `smart_groups`;
CREATE TABLE IF NOT EXISTS `smart_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google_group_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smart` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `regexp` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3;

insert into smart_groups (id, name, email, google_group_id, smart, `type`,`regexp`,description) values (1, "2019", "2019@dumassachools.net", "03q5sasy31jka7a", 1, 1, "19*","fish");
insert into smart_groups (id, name, email, google_group_id, smart, `type`,`regexp`,description) values (2, "2018", "2018@dumassachools.net", "03x8tuzt2gq5esc", 1, 1, "18*","fish");
insert into smart_groups (id, name, email, google_group_id, smart, `type`,`regexp`,description) values (3, "2017", "2017@dumassachools.net", "02s8eyo13wvv2ja", 1, 1, "17*","fish");


