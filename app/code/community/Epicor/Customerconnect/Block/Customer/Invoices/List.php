<?php

/**
 * Customer Invoices list
 */
class Epicor_Customerconnect_Block_Customer_Invoices_List extends Epicor_Common_Block_Generic_List {

    protected function _setupGrid() {
        $this->_controller = 'customer_invoices_list';
        $this->_blockGroup = 'customerconnect';
        $this->_headerText = Mage::helper('epicor_comm')->__('Invoices');
    }

}