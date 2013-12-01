magento-cemimport
=================

Magento CEMImport Extension for importing data to Liana CEM


Usage
=====

1. Copy/upload app/code/local/Liana/CEMimport to your [magento_folder]/app/code/local/

2. Open Magento's settings page and open the Liana CEM Import section and enter these required fields:
	- API USER
	- API KEY
	- API URL
	- API VERSION
Afterward click "Save config" to finnished this step
(If when you open Liana CEM Import section and see the 404 error, you may need to logout and login to Magento again)

3. Set up cronjob to excute CEM Import module in every 2 minutes
	- */2 * * * /usr/bin/php -f /local/path/to/magento/cron.php