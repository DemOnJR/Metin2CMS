
CREATE TABLE IF NOT EXISTS `cms_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mentiuni` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cms_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `version` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `url` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `size` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cms_is_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `icon` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cms_is_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `vnum` int(128) NOT NULL,
  `price` int(128) NOT NULL,
  `catid` int(64) NOT NULL,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `autor` varchar(128) CHARACTER SET ucs2 COLLATE ucs2_bin NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `continut` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `cms_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `read` enum('Y','N') NOT NULL DEFAULT 'N',
  `subject` varchar(200) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cms_settings` (
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `cms_log_ishop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `action` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cms_settings` (`name`, `value`) VALUES
  ('droprate', '12'),
  ('exprate', '12'),
  ('yangrate', '12'),
  ('gamemode', 'PVP'),
  ('svname', 'Aries2'),
  ('forum-url', '#'),
  ('top_limit', '10'),
  ('register_on', 'true'),
  ('captcha', 'true'),
  ('notification_state', 'true');