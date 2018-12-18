<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feed
 *
 * @author Paul.Ketelle
 */
class Epicor_ProductFeed_Block_Frontend_Google_Feed extends Mage_Core_Block_Template
{
    protected $_products;
    /**
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product;
    
    protected $_zeroPrice;


    public function setProducts($products) {
        $this->_products = $products;
    }
    public function getproducts(){
        return  $this->_products;
    }
        
    public function getProductCategory() {
        $googleCat = Mage::getStoreConfig('epicor_productfeed/google/google_category');
        return Mage::helper('productfeed/google')->xmlSafeString($googleCat);
    }
    
    public function getProductPath() {
        $paths = array();
        foreach(array_reverse($this->_product->getCategoryIds()) as $cat_id)
        {
            $category = Mage::getModel('catalog/category')->load($cat_id);
            
            $pathInStore = $category->getPathInStore();
            if($pathInStore){                
                $pathIds = array_reverse(explode(',', $pathInStore));
                $categories = $category->getParentCategories();
                $path = array();
                foreach($pathIds as $pathId) {
                    if (isset($categories[$pathId]))
                    {
                        $path[] = Mage::helper('productfeed/google')->xmlSafeString($categories[$pathId]->getName());
                    }
                    else
                    { $path[] = $pathId;

                    }
                }
                if(count($path) > 0)
                    $paths[] = join(' &gt; ', $path);

                if(count($paths) >= 10)
                    break;
            }    
        }
        return $paths;
    }
        
    public function getPrice() {
        $this->_zeroPrice = false;
        $oldPrice = $this->_product->getPrice();
        
        $tax_config = Mage::getSingleton('tax/config');
        /* @var $tax_config Mage_Tax_Model_Config */
        $price = $this->_product->getFinalPrice(1);
        
        if(!$tax_config->priceIncludesTax())  {
            $price = Mage::helper('tax')->getPrice($this->_product, $price, true);
        }
        
        if($price == 0) {
            $price = $oldPrice;
            $this->_zeroPrice = true;
        }
        return $price;
    }
    
    public function getProductId() {
        if(Mage::getStoreConfigFlag('epicor_productfeed/google/id_strict'))
            $id = preg_replace('/[^\w]|_/', '', $this->_product->getSku());
        else
            $id = $this->_product->getSku();
        
        return htmlentities($id);
    }
    
    public function getWeight() {
        return $this->_product->getWeight() ? $this->_product->getWeight() : 0;
    }
    
    public function getFeedTitle()
    {
        return Mage::getStoreConfig('epicor_productfeed/google/feed_title');
    }
    
    public function getFeedDescription()
    {
        return Mage::getStoreConfig('epicor_productfeed/google/feed_description');
    }
    
    public function getAvailability()
    {
        $avail =  Mage::getStoreConfig('epicor_productfeed/google/stock_avail');
        if ($avail =='default')
        {
            if ($this->_product->getQty() > 0)
                return 'in stock';
            else
                return Mage::getStoreConfig('epicor_productfeed/google/stock_avail_def_out');
        }
        else
        {
            return $avail;
        }
    }
    
    public function validate()
    {
        // Mpn, Brand and category must be present to be included. gtin priority: upc, ean, ISBN
        if($this->_product->getBrand() && $this->_product->getMpn() && count($this->_product->getCategoryIds()) > 0){            
            $gtinValues = array('ISBN', 'ean', 'upc');
            foreach($gtinValues as $value){
                if($this->_product->getData($value)){
                        $this->_product->setGtin($this->_product->getData($value));
                }
            }
            return true;
        }
        return false; 
    }
    
    public function getProductUrl()
    {
        $suffix = Mage::getStoreConfig('epicor_productfeed/google/url_suffix');
        $url= $this->_product->getProductUrl() . $suffix;
        return $url;
    }
    
    
}


