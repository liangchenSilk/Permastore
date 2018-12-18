<?php

/**
 * Sites grid container
 * 
 * @category   Epicor
 * @package    Epicor_ConflictChecker
 * @author     Epicor Websales Team
 */
class Epicor_ConflictChecker_Block_Adminhtml_Check_Templates extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {

        $this->_blockGroup = 'conflictchecker';
        $this->_controller = 'adminhtml_check_templates';
        $this->_headerText = Mage::helper('conflictchecker')->__('Templates');
        parent::__construct();
        $this->removeButton('add');
    }

}
//class Epicor_ConflictChecker_Block_Adminhtml_Check_Templates extends Mage_Adminhtml_Block_Template
//{
//    
//}