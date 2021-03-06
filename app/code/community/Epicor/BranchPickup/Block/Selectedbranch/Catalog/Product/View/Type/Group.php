<?php
/**
 * Branch Pickup Block
 *
 * @category   Epicor
 * @package    Epicor_BranchPickup
 * @author     Epicor Websales Team
 */

class Epicor_BranchPickup_Block_Selectedbranch_Catalog_Product_View_Type_Group extends Epicor_BranchPickup_Block_Selectedbranch
{
    /**
     * Returns the current product
     * 
     * @return Epicor_Comm_Model_Product
     */
    public function getProduct()
    {
        return $this->getData('current_uom');
    }
}