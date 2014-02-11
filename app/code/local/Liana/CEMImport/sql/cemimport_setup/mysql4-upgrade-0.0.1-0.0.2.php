<?php

$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
ALTER TABLE cemimport CHANGE last_created_at_time last_updated_at_time datetime;

");

$installer->endSetup();