magento-cemimport
=================

Magento CEMImport Extension for importing data to Liana CEM


Usage
=====

1. Copy/upload app/code/local/Liana/CEMImport to your [magento_folder]/app/code/local/

2. Copy/upload app/etc/modules/Liana_CEMImport.xml to your [magento_folder]/app/etc/modules/

3. Open Magento's settings page and open the Liana CEM Import section and enter these required fields:
	- API USER
	- API KEY
	- API URL
	- API VERSION
Afterward click "Save config" to finnished this step
(If when you open Liana CEM Import section and see the 404 error, you may need to logout and login to Magento again)

4. Set up cronjob to excute CEM Import module in every 2 minutes
	- */2 * * * * /usr/bin/php -f /local/path/to/magento/cron.php
OR
	- */2 * * * * curl -s -o /dev/null http://www.yoursite.com/absolute/path/to/magento/cron.php

Development
=====

You have to install [EcomDev PHPUnit](http://www.magentocommerce.com/magento-connect/phpunit-testing-integration.html) in order to run phpunit test

