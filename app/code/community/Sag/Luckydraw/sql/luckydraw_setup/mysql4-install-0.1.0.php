<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('luckydraw')};
CREATE TABLE {$this->getTable('luckydraw')} (
  `luckydraw_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`luckydraw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
	
	

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('subscriber')};
CREATE TABLE {$this->getTable('subscriber')} (
  `subscriber_id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_email` varchar(256) NOT NULL,
  `luckydraw_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$installer->endSetup(); 