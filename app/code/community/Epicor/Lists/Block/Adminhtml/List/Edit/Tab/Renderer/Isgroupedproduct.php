<?php

class Epicor_Lists_Block_Adminhtml_List_Edit_Tab_Renderer_Isgroupedproduct extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $html = null;
        if ($row->getTypeId() == 'grouped' || $row->getTypeId() == 'configurable') {
            $title = Mage::helper('epicor_comm')->__('This product has multiple products associated with it. Enabling / Disabling it will have the same effect on its associated products');
            $imgurl =Mage::getBaseUrl( Mage_Core_Model_Store::URL_TYPE_WEB, true ).'skin/frontend/base/default/images/group_icon.png';
            $html = "<img width='20px' height='20px' title='$title' src='$imgurl'>";
        }
        return $html;
    }

}
