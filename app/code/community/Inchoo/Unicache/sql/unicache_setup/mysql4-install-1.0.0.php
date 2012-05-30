<?php
$now = date('Y-m-d H:i:s');
$installer = $this;
$installer->startSetup();
$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('unicache')};
CREATE TABLE {$this->getTable('unicache')}(
	`unicache_id` int(11) unsigned NOT NULL auto_increment,
	`name` varchar(255) NOT NULL default 'unknown',
	`content` text NULL,
	`updated_time` datetime NOT NULL default '$now',
	`cache_timeout` int(11) NOT NULL default 24,
	PRIMARY KEY (`unicache_id`)
) ENGINE InnoDB DEFAULT CHARSET=utf8;

");
$installer->endSetup();