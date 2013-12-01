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

        $data = json_encode(
            array(
                'channel' => 1,
                'data' => array (
                    array(
                        'identity' => array('email' => 'eureka287@yahoo.com'),
                        'events' => array(
                            array('verb' => 'contact', 'data' => array('first-name' => 'hung', 'last-name' => 'nguyen', 'occupation' => null)),
                            array('verb' => 'order',   'data' => array('item-name' => 'Test Product 1', 'price' => 10.0)),
                            array('verb' => 'order',   'data' => array('item-name' => 'Test Product 3.2', 'price' => 30.0)),
                            array('verb' => 'order',   'data' => array('item-name' => 'Test Product 2.1', 'price' => 20.0))
                        )
                    )
                )
            )
        );
        echo "\n".$data;
        // Check that two json objects are equal or not
        $this->assertJsonStringEqualsJsonString(
            $data,
            $jsonOrderList
        );
     }

}