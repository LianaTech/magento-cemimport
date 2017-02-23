<?php

// TC:
// 1. Mockup product data
// 2. Make order
// 3. Get data of order
// email; product_category; product_name; etc
// 4. Transform data to JSON / CSV format
// 5. Mockup REST client request
//

class Liana_CEMImport_Test_Model_Customer extends EcomDev_PHPUnit_Test_Case {


    /**
     * Retrieves list of customers
     *
     * @test
     */
    public function getJSON() {

        $model = new Liana_CEMImport_Model_Customer();
        $jsonCustomerList = $model->getCustomerListJSON();

		$data = json_encode(array (
		  'channel' => 'ecs',
		  'data' =>
		  array (
			array (
			  'identity' => array ( 'email' => 'eureka287@yahoo.com',),
			  'events' =>
			  array (
				array (
				  'verb' => 'contact',
				  'items' => array ( 'id' => '1', 'first-name' => 'hung', 'last-name' => 'nguyen', 'email' => 'eureka287@yahoo.com',),
				),
			  ),
			),
		  ),
		));

		echo "\n".$jsonCustomerList."\n";
        // Check that two json objects are equal or not
        $this->assertJsonStringEqualsJsonString(
            $data,
            $jsonCustomerList
		);
	}
}
