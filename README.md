magento-cemimport
=================

Magento CEMImport Extension for importing data to Liana CEM

* Currently, this module will import customers and orders data from Magento to CEM
* Magento version up to 1.9.x is supported. Magento 2 is currently not supported.

Usage
=====

1. Copy/upload app/code/local/Liana to your [magento_folder]/app/code/local/

2. Copy/upload app/etc/modules/Liana_CEMImport.xml to your [magento_folder]/app/etc/modules/

3. Copy/upload shell/cemimport-cli.php to your [magento_folder]/shell/

4. Open Magento's settings page (System/Configuration/Liana CEM Import) and open the Liana CEM Import section and enter these required fields:
	- API USER
	- API KEY
	- API URL (e.g:http://t.lianacem.com, it does not need to contain /rest segment or version)
	- API VERSION
	- API REALM
	- CEM Channel - id (in the URL of the channel in CEM) or systemname of the CEM channel (defaults to `ecs`, LianaCommerce)

  *Afterward click "Save config" to finnished this step (If when you open Liana CEM Import section and see the 404 error, you need to logout and login to Magento again).
  

5. Set up cronjob to execute CEM Import module in every 2 minutes
	- */2 * * * * /usr/bin/php -f /local/path/to/magento/cron.php
OR
	- */2 * * * * curl -s -o /dev/null http://www.yoursite.com/absolute/path/to/magento/cron.php

###Run importing process directly from command line

You can also run the import process from command line by execute:
php -f shell/cemimport-cli.php

It will automatically export customers and orders to CEM once (maximum 1000 rows per time)

Development
=====

You have to install [EcomDev PHPUnit](http://www.magentocommerce.com/magento-connect/phpunit-testing-integration.html) in order to run phpunit test

