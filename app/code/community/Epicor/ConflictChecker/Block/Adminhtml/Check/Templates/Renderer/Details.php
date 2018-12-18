<?php

/**
 * Log subject renderer
 *
 * @category   Epicor
 * @package    Epicor_Comm
 * @author Epicor Websales Team
 */
class Epicor_ConflictChecker_Block_Adminhtml_Check_Templates_Renderer_Details extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Render country grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row) {
        $data = $row->getData($this->getColumn()->getIndex());
        return nl2br(str_replace(array(' ',"\t"),array('&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;'), $data));
    }

}
