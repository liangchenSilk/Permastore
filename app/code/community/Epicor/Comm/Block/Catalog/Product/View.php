<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Paul.Ketelle
 */
class Epicor_Comm_Block_Catalog_Product_View extends Mage_Catalog_Block_Product_View 
{
    public function getProduct()
    {
        $product = parent::getProduct();
        if(Mage::app()->getRequest()->getParam('qty', false)) {
            $product->setPreconfiguredValues(
                    $product->getPreconfiguredValues()
                    ->setQty(
                            Mage::app()->getRequest()->getParam('qty')
                            )
                    );
        }
        return $product;
    }
    
    public function getSkuEditUrl($entityId){
        return $this->getUrl('customerconnect/skus/edit', array('id' => $entityId));
    }
    
    public function getSkuAddUrl($productId){
        return $this->getUrl('customerconnect/skus/create', array('id' => $productId));
    }
    
    /**
     * Return price block
     *
     * @param string $productTypeId
     * @return mixed
     */
    public function _getPriceBlock($productTypeId)
    {
        return parent::_getPriceBlock($productTypeId);
    }
    
    /**
     * Check to enable Add to cart button for Configurable/Group product
     * 
     * @param type $_product
     * @return boolean
     */
    public function checkGroupOrConfigurable($_product)
    {
        switch($_product->getTypeId()) {
            case 'configurable':
                return true;
                break;
            case 'grouped':
                $locationCodes = array();
                $result = $_product->getTypeInstance(true)
                    ->getAssociatedProducts($_product);
                $storeId = $_product->getStoreId();
                foreach ($result as $item) {
                    $item->setStoreId($storeId);
                    foreach ($item->getCustomerLocations() as $locationCode => $location) {
                        if (!in_array($locationCode, $locationCodes)) {
                            $locationCodes[] = $locationCode;
                        }
                    }
                }
                return (count($locationCodes) > 0) ? true : false;
                break;
        }
        return false;
    }
    
    /**
     * Add meta information from product to head block
     * @return Mage_Catalog_Block_Product_View
     * Method overrided to fix fatal error reported in WSO-6013
     */
    protected function _prepareLayout() {
        $this->getLayout()->createBlock('catalog/breadcrumbs');
        $headBlock = $this->getLayout()->getBlock('head');
        $product = $this->getProduct();
        if ($headBlock && $product) {
            $title = $product->getMetaTitle();
            if ($title) {
                $headBlock->setTitle($title);
            }
            $keyword = $product->getMetaKeyword();
            $currentCategory = Mage::registry('current_category');
            if ($keyword) {
                $headBlock->setKeywords($keyword);
            } elseif ($currentCategory) {
                $headBlock->setKeywords($product->getName());
            }
            $description = $product->getMetaDescription();
            if ($description) {
                $headBlock->setDescription(($description));
            } else {
                $headBlock->setDescription(Mage::helper('core/string')->substr($product->getDescription(), 0, 255));
            }
            if ($this->helper('catalog/product')->canUseCanonicalTag()) {
                $params = array('_ignore_category' => true);
                $headBlock->addLinkRel('canonical', $product->getUrlModel()->getUrl($product, $params));
            }
        }

        return parent::_prepareLayout();
    }

}
