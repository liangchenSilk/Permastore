<?php


class DotNetIT_OrderInfo_Block_Customer_Orders_Details_Info extends Epicor_Customerconnect_Block_Customer_Orders_Details_Info {

    public function _construct() {
        echo'<pre>';
        var_dump("extension works");
        exit;
        parent::_construct();
        $order = Mage::registry('customer_connect_order_details');
        $this->_infoData = array(
            $this->__('Order Date :') => $order->getOrderDate() ? $this->getHelper()->getLocalDate($order->getOrderDate(), Epicor_Common_Helper_Data::DAY_FORMAT_MEDIUM, true) : $this->__('N/A'),
            $this->__('Need By :') => $order->getRequiredDate() ? $this->getHelper()->getLocalDate($order->getRequiredDate(), Epicor_Common_Helper_Data::DAY_FORMAT_MEDIUM, true) : $this->__('N/A'),
            $this->__('Terms :') => $order->getPaymentTerms(),
            $this->__('PO Number :') => $order->getCustomerReference(),
            $this->__('Sales Person :') => $order->getSalesRep()->getName(),
            $this->__('Ship Via :') => $order->getDeliveryMethod(),
            $this->__('FOB :') => $order->getFob(),
            $this->__('Tax Id :') => $order->getTaxid(),
            $this->__('Test Val :') => "test data"
                );
        $this->setTitle($this->__('Order Information :'));
    }
    
}