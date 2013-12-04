<?php

$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('cemimport')};
CREATE TABLE `{$this->getTable('cemimport')}` (
  `cemimport_id` int(11) unsigned NOT NULL auto_increment,
  `import_type` varchar(10) NULL,
  `last_created_at_time` datetime NULL,
  `last_retrieved_id` int(11) NULL,
  PRIMARY KEY (`cemimport_id`),
  INDEX(`import_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();