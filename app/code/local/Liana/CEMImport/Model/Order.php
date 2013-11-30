<?php
class Liana_CEMImport_Model_Order extends Mage_Core_Model_Abstract {


    public function getOrderCollectionByID($order_ids = array()){
        $collection = $this->getOrderCollection();
        //var_dump((string)$collection->getSelect());die(1);

        $collection->addAttributeToFilter('entity_id', array('in' => $order_ids));
        return $collection;
    }

    /**
    * Retrieve a collection of order from database through magento
    **/
    public function getOrderCollection(){
        $collection = Mage::getModel('sales/order')->getCollection();//->setOrder('created_time','ASC');
        return $collection;
    }
    
    /**
    *   Retrieve a order list from database and convert it into proper array structure
    */
    public function getOrderList(){
        $collection = $this->getOrderCollection();

        $channel_id = 1;
        $data = array();
        $data['channel'] = $channel_id;
        $orders = array();

        foreach($collection as $item){         
            $order = array();
            
            $order['identity'] = array('email'=> $item->getCustomerEmail());
            
            $billing_address = $item->getBillingAddress();

            $order['events'][] = array(
                'verb' => 'contact',
                'data' => array(
                    'first-name' => $item->getCustomerFirstname(),
                    'last-name'  => $item->getCustomerLastname(),
					'street'	 => $billing_address->getStreetFull(),
					'zip'		 => $billing_address->getPostcode(),
					'city'		 => $billing_address->getCity()
                )
            );
            
 			$order['events'][] = array(
                'verb' => 'order',
                'data' => array(
                    'order-id' 	 		=> $item->getId(),
                    'order-number'  	=> $item->getIncrementId(),
					'payment-method'	=> $item->getPayment()->getMethodInstance()->getCode(),
					'delivery-method'	=> $item->getShippingDescription(),
					'total-price'		=> $item->getSubtotal(),
                    'currency' 		    => $item->getOrderCurrencyCode(),
					'status'            => $item->getStatus(),
                    'created'           => $item->getCreatedAt(),
                    'modified'          => $item->getUpdatedAt(),
                )
            );

            $details = $this->getOrderDetails($item);

            $order['events'] = array_merge($order['events'], $details);

 			$orders[] = $order;
        }

        $data['data'] = $orders;

        return $data;
     }

    /**
    * Convert the array structure of Order list into JSON
    */
    public function getOrderListJSON(){
        $data = $this->getOrderList();
        return json_encode($data);
    }

    /**
    * Get order details from an order
    */
    public function getOrderDetails($order){
        $order_rows = array();
        foreach($order->getItemsCollection() as $item)
        {
            $row                      = array();
            $row['verb'] 			  = 'order-row';
            $row['data']['item-name'] = $item->getName();
			$row['data']['amount'] 	  = $item->getQtyOrdered();
            $row['data']['price']     = $item->getPrice();
			$row['data']['row-total'] = $item->getRowTotalInclTax();
            $order_rows[] = $row;
        }
        return $order_rows;
    }
}
