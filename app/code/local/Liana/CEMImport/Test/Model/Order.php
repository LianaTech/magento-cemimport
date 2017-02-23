<?php

// TC:
// 1. Mockup product data
// 2. Make order
// 3. Get data of order
// email; product_category; product_name; etc
// 4. Transform data to JSON / CSV format
// 5. Mockup REST client request
//

class Liana_CEMImport_Test_Model_Order extends EcomDev_PHPUnit_Test_Case {

    /**
     * Retrieves list of order ids for some purpose
     *
     * @test
     */
    public function getJSON()
    {
        $model = new Liana_CEMImport_Model_Order();
		$jsonOrderList = $model->getOrderListJSON();

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
				  'items' => 
				  array (
					'first-name' => 'hung',
					'last-name' => 'nguyen',
					'street' => 'Peltolaankaari 6 A33',
					'zip' => '90230',
					'city' => 'Oulu',
				  ),
				),
				array (
				  'verb' => 'order',
				  'items' => 
				  array (
					'id' => '100000001',
					'payment-method' => 'checkmo',
					'delivery-method' => 'Flat Rate - Fixed',
					'total-price' => '10.0000',
					'currency' => 'EUR',
					'status' => 'pending',
					'created' => '2013-11-13 08:45:42',
					'modified' => '2013-11-13 09:15:40',
				  ),
				),
				array (
				  'verb' => 'orderrow',
				  'items' => 
				  array (
					'order-id' => '100000001',
					'product-id' => '1',
					'sku' => 'SKU001',
					'name' => 'Test Product 1',
					'amount' => '1.0000',
					'price' => '10.0000',
					'total' => '10.0000',
				  ),
				),
			  ),
			),
			array (
			  'identity' => array ( 'email' => 'eureka287@yahoo.com',),
			  'events' => 
			  array (
				array (
				  'verb' => 'contact',
				  'items' => 
				  array (
					'first-name' => 'hung',
					'last-name' => 'nguyen',
					'street' => 'Peltolaankaari 6 A33',
					'zip' => '90230',
					'city' => 'Oulu',
				  ),
				),
				array (
				  'verb' => 'order',
				  'items' => 
				  array (
					'id' => '100000002',
					'payment-method' => 'checkmo',
					'delivery-method' => 'Flat Rate - Fixed',
					'total-price' => '30.0000',
					'currency' => 'EUR',
					'status' => 'pending',
					'created' => '2013-11-13 08:46:09',
					'modified' => '2013-11-13 09:15:40',
				  ),
				),
				array (
				  'verb' => 'orderrow',
				  'items' => 
				  array (
					'order-id' => '100000002',
					'product-id' => '2',
					'sku' => 'SKU003',
					'name' => 'Test Product 3.2',
					'amount' => '1.0000',
					'price' => '30.0000',
					'total' => '30.0000',
				  ),
				),
			  ),
			),
			array (
			  'identity' => array ( 'email' => 'eureka287@yahoo.com',),
			  'events' => 
			  array (
				array (
				  'verb' => 'contact',
				  'items' => 
				  array (
					'first-name' => 'hung',
					'last-name' => 'nguyen',
					'street' => 'Peltolaankaari 6 A33',
					'zip' => '90230',
					'city' => 'Oulu',
				  ),
				),
				array (
				  'verb' => 'order',
				  'items' => 
				  array (
					'id' => '100000003',
					'payment-method' => 'checkmo',
					'delivery-method' => 'Flat Rate - Fixed',
					'total-price' => '20.0000',
					'currency' => 'EUR',
					'status' => 'complete',
					'created' => '2013-11-13 08:46:29',
					'modified' => '2013-11-13 09:48:54',
				  ),
				),
				array (
				  'verb' => 'orderrow',
				  'items' => 
				  array (
					'order-id' => '100000003',
					'product-id' => '3',
					'sku' => 'SKU002',
					'name' => 'Test Product 2.1',
					'amount' => '1.0000',
					'price' => '20.0000',
					'total' => '20.0000',
				  ),
				),
			  ),
			),
		  ),
		));

		echo "\n$jsonOrderList\n";
        // Check that two json objects are equal or not
        $this->assertJsonStringEqualsJsonString(
            $data,
            $jsonOrderList
        );
     }

}
