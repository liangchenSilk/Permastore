<?php

class Epicor_Comm_Block_Adminhtml_Customer_Edit_Tab_Locations extends Mage_Adminhtml_Block_Widget_Grid implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    private $_selected = array();

    public function __construct()
    {
        parent::__construct();
        $this->setId('locationsGrid');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(false);
        $this->setDefaultFilter(array('in_location' => 1));
        $this->setRowInitCallback('toggleLocationsEdit');
    }

    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_location') {

            $productIds = $this->_getSelected();
            if (empty($productIds)) {
                $productIds = array(0);
            }

            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('code', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('code', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    public function canShowTab()
    {
        return true;
    }

    public function getTabLabel()
    {
        return 'Locations';
    }

    public function getTabTitle()
    {
        return 'Locations';
    }

    public function isHidden()
    {
        return false;
    }

    /**
     * 
     * @return Epicor_Comm_Model_Customer
     */
    public function getCustomer()
    {
        if (!$this->_customer) {
            $this->_customer = Mage::registry('current_customer');
        }
        return $this->_customer;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('epicor_comm/location')->getCollection();
        $customer = $this->getCustomer();

        $allowed = $customer->getCustomerErpAccount()->getAllowedLocationCodes();
        $collection->addFieldToFilter('code', array('in' => $allowed));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('in_location', array(
            'header' => Mage::helper('sales')->__('Select'),
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_location',
            'values' => $this->_getSelected(),
            'align' => 'center',
            'index' => 'code',
            'sortable' => false,
            'field_name' => 'links[]',
            'use_index' => true,
            'column_css_class' => 'location_set',
            'header_css_class' => 'location_set'
        ));

        $this->addColumn('location_code', array(
            'header' => Mage::helper('epicor_comm')->__('Location Code'),
            'width' => '150',
            'index' => 'code',
            'filter_index' => 'code'
        ));

        $this->addColumn('location_name', array(
            'header' => Mage::helper('epicor_comm')->__('Name'),
            'width' => '150',
            'index' => 'name',
            'filter_index' => 'name'
        ));

        $this->addColumn('row_id', array(
            'header' => Mage::helper('catalog')->__('Position'),
            'name' => 'row_id',
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'code',
            'width' => 0,
            'editable' => true,
            'column_css_class' => 'no-display',
            'header_css_class' => 'no-display'
        ));

        return parent::_prepareColumns();
    }
    
    protected function _getSelected()
    {   // Used in grid to return selected customers values.
        return array_keys($this->getSelected());
    }

    public function getSelected()
    {
        if (empty($this->_selected) && $this->getRequest()->getParam('ajax') !== 'true') {
            $customer = $this->getCustomer();

            $locations = $customer->getAllowedLocationCodes();
            foreach ($locations as $locationCode) {
                $this->_selected[$locationCode] = array('code' => $locationCode);
            }
        }
        return $this->_selected;
    }

    public function setSelected($selected)
    {
        if (!empty($selected)) {
            foreach ($selected as $id) {
                $this->_selected[$id] = array('id' => $id);
            }
        }
    }

    public function getGridUrl()
    {
        $params = array(
            'id' => $this->getCustomer()->getId(),
            '_current' => true,
        );
        return $this->getUrl('adminhtml/epicorcomm_customer/locationsgrid', $params);
    }

}
