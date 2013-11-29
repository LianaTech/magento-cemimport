<?php
require_once 'abstract.php';
class Liana_Shell_CEMImport extends Mage_Shell_Abstract
{
    protected $_argname = array();
    public function __construct() {
        parent::__construct();
        // Time limit to infinity
        set_time_limit(0);
        // Get command line argument named "argname"
        // Accepts multiple values (comma separated)
        if($this->getArg('argname')) {
            $this->_argname = array_merge(
                $this->_argname,
                array_map(
                    'trim',
                    explode(',', $this->getArg('argname'))
                )
            );
        }
    }
    // Shell script point of entry
    public function run() {
        echo "Hello World";
        $api_user       = Mage::getStoreConfig('cemimport/settings/api_user');
        $api_key        = Mage::getStoreConfig('cemimport/settings/api_key');
        $api_url        = Mage::getStoreConfig('cemimport/settings/api_url');
        $api_version    = Mage::getStoreConfig('cemimport/settings/api_version');

        $restClient = new Liana_CEMImport_Model_RestClient(
            $api_user, $api_key, $api_url, $api_version
        );

        $model = new Liana_CEMImport_Model_Order();

        $orderList = $model->getOrderList();

        $restClient->call('import', $orderList);
    }
    // Usage instructions
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f scriptname.php -- [options]
  --argname <argvalue>       Argument description
  help                   This help
USAGE;
    }
}
// Instantiate
$shell = new Liana_Shell_CEMImport();
// Initiate script
$shell->run();
