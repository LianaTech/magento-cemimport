<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('cemimport')};
CREATE TABLE {$this->getTable('cemimport')} (
  `cemimport_id` int(11) unsigned NOT NULL auto_increment,
  `last_created_at_time` datetime NULL,
  `last_order_id` int(11) NULL,
  PRIMARY KEY (`cemimport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
    ");
 
$installer->endSetup();