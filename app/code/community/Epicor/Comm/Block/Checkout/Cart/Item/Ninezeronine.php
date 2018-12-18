<?php

/**
 * Cart item ninezeronine
 * 
 * @category   Epicor
 * @package    Epicor_Comm
 * @author     Epicor Websales Team
 */
class Epicor_Comm_Block_Checkout_Cart_Item_Ninezeronine extends Mage_Core_Block_Template
{

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('epicor_comm/checkout/cart/item/ninezeronine.phtml');
    }

    public function getItem() {
        return $this->getParentBlock()->getItem();
    }
}
