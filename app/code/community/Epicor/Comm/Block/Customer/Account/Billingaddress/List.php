<?php

/**
 * Customer Orders list
 */
class Epicor_Comm_Block_Customer_Account_Billingaddress_List extends Epicor_Common_Block_Generic_List {

    protected function _setupGrid() {
        $this->_controller = 'customer_account_billingaddress_list';
        $this->_blockGroup = 'epicor_comm';
        $this->_headerText = Mage::helper('epicor_comm')->__('Billing');
            $this->_addButton('close', array(
                'id' => 'close-button',
                'label' => Mage::helper('customerconnect')->__('Close'),
                       'onclick'   =>  "onepageAddressSearchClosePopup()",
                'class' => 'close',
                    ), -100);
    }

    protected function _postSetup() {
        $this->setBoxed(true);
        parent::_postSetup();
    }

}