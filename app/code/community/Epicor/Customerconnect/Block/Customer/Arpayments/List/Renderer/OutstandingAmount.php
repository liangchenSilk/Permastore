<?php

/**
 * AR Payment link grid renderer
 * 
 * @category   Epicor
 * @package    Epicor_Customerconnect
 * @author     Epicor Websales Team
 */
class Epicor_Customerconnect_Block_Customer_Arpayments_List_Renderer_OutstandingAmount extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
        $html='';
        if($row->getSelectArpayments() !="Totals") {
            $subtraction = "0.000";
            $termamount = $row->getTermBalance();
            if($termamount) {
                $termbalance =$termamount;
            } else {
               $termbalance="0.000"; 
            }
            if($termbalance) {
               $html .='<input type="hidden" name="settlement_discount" value="'.$subtraction.'" id="settlement_discount_' . $row->getId() . '" class="settlement_discount"/>';
               $html .='<input type="hidden" name="settlement_term_amount" value="'.$termbalance.'" id="settlement_term_amount_' . $row->getId() . '" class="settlement_term_amount"/>';
               $html .= '<span class="price">'.$currencySymbol.$termbalance.'</span>'; 
            } else {
              $subtraction ="0.000";
              $html  .='<input type="hidden" name="settlement_term_amount" value="'.$termbalance.'" id="settlement_term_amount_' . $row->getId() . '" class="settlement_term_amount"/>';
              $html  .='<input type="hidden" name="settlement_discount" value="'.$subtraction.'" id="settlement_discount_' . $row->getId() . '" class="settlement_discount"/>';
              $html  .= '<span class="price">'.$termbalance.'</span>';
            }
        } 
        return $html;
    }
    
    public function renderCss()
    {
        return 'arpay-noalign';
    }     

}