<?php

/**
 * RFQ line is kit column renderer
 * 
 * @category   Epicor
 * @package    Epicor_Customerconnect
 * @author     Epicor Websales Team
 */
class Epicor_Customerconnect_Block_Customer_Rfqs_Details_Lines_Renderer_Iskit extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{

    public function render(Varien_Object $row)
    {
        $key = Mage::registry('rfq_new') ? 'new' : 'existing';
        $index = $this->getColumn()->getIndex();
        $value = $row->getData($index);
        $html = '<span class="is_kit_display">' . $value . '</span>';
        $html .= '<input class="lines_is_kit" type="hidden" name="lines[' . $key . '][' . $row->getUniqueId() . '][is_kit]" value="' . $value . '" /> ';
        
        
        //check if isKit == Y, ie if a bundle 
        if($row->getIsKit() == 'Y'){    
            Mage::helper('customerconnect')->saveChildrenOfBundle($row->getProductCodeValue());
        }
        if($row->getIsKit() == 'C'){
            $parent = Mage::registry('kit_component_parent_'.$row->getProductCodeValue());
            if($parent){
                //return parent sku;
                $html .= '<input class="lines_kit_component_parent" type="hidden" value="' . $parent . '" /> ';
            }
        }
        
        
        return $html;
        
        
    }

}
