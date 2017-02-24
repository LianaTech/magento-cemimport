<?php
require_once 'abstract.php';
class Liana_Shell_CEMImport extends Mage_Shell_Abstract {
    protected $_argname = array();
    public function __construct() {
        parent::__construct();
        set_time_limit(0);
	}

    public function run() {
        Liana_CEMImport_Model_Observer::getInstance()->exportOrders();
        Liana_CEMImport_Model_Observer::getInstance()->exportCustomers();
	}

	public function usageHelp() {
		$filename = basename(__FILE__);
		return <<<USAGE
Usage:  php $filename [options]
	--help  This help

USAGE;
    }
}

$shell = new Liana_Shell_CEMImport();
$shell->run();
