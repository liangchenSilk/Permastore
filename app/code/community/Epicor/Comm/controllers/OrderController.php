<?php

/**
 * Order controller
 *
 * @category   Epicor
 * @package    Epicor_Comm
 * @author     Epicor Websales Team
 */
require_once(Mage::getModuleDir('controllers', 'Mage_Sales') . DS . 'OrderController.php');

class Epicor_Comm_OrderController extends Mage_Sales_OrderController {

    /**
     * Check order view availability
     *
     * @param   Mage_Sales_Model_Order $order
     * @return  bool
     */
    protected function _canViewOrder($order) {
        /* WSO-5620 due to satus mapping customer can create 'n' no status */
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($order->getId() && $order->getCustomerId() && ($order->getCustomerId() == $customerId)) {
            return true;
        }
        return false;
    }

}
