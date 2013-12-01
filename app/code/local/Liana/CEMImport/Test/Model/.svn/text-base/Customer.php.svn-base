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
     * Retrieves list of customer
     *
     * @test
     */
    public function getJSON()
    {
        $model = new Liana_CEMImport_Model_Customer();
        $jsonCustomerList = $model->getCustomerListJSON();

        $data = json_encode(
            array(
                'channel' => 1,
                'data' => array (
                    array(
                        'identity' => array('email' => 'eureka287@yahoo.com'),
                        'events' => array(
                            array('verb' => 'customer', 'data' => array('first-name' => 'hung', 'last-name' => 'nguyen', 'occupation' => null)),
                        )
                    )
                )
            )
        );
        echo "\n".$data;
        // Check that two json objects are equal or not
        $this->assertJsonStringEqualsJsonString(
            $data,
            $jsonCustomerList
        );
     }

}