<?php

/**
 * Hosting Sites Grid
 * 
 * @category   Epicor
 * @package    Epicor_ConflictChecker
 * @author     Epicor Websales Team
 */
class Epicor_ConflictChecker_Block_Adminhtml_Check_Templates_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        $this->setId('entity_id');
        $this->setDefaultSort('template_match');
        $this->setDefaultDir('ASC');
        if($this->getParam($this->getVarNameFilter(), null) === null) {
            $this->getRequest()->setParam($this->getVarNameFilter(), "dGVtcGxhdGVfbWF0Y2g9ZmFsc2U=");
        }
        
        parent::__construct();
    }

    protected function _prepareCollection()
    {
        $helper = Mage::helper('conflictchecker');
        /* @var $helper Epicor_ConflictChecker_Helper_Data */

        $collection = $helper->getComparedTemplateDataCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('layout_file', array(
            'header' => Mage::helper('conflictchecker')->__('Layout XML file'),
            'align' => 'left',
            'index' => 'layout_file',
        ));

        $this->addColumn('handle', array(
            'header' => Mage::helper('conflictchecker')->__('Page handle'),
            'align' => 'left',
            'index' => 'handle',
        ));

        $this->addColumn('reference', array(
            'header' => Mage::helper('conflictchecker')->__('Reference'),
            'align' => 'left',
            'index' => 'reference',
        ));

//        $this->addColumn('action', array(
//            'header' => Mage::helper('conflictchecker')->__('action'),
//            'align' => 'left',
//            'index' => 'action',
//        ));
        $this->addColumn('template_set_in', array(
            'header' => Mage::helper('conflictchecker')->__('Set In'),
            'align' => 'left',
            'renderer' => new Epicor_ConflictChecker_Block_Adminhtml_Check_Templates_Renderer_Details(),
            'index' => 'template_set_in',
        ));
        $this->addColumn('template', array(
            'header' => Mage::helper('conflictchecker')->__('Expected Template'),
            'align' => 'left',
            'index' => 'template',
        ));
        $this->addColumn('template_found', array(
            'header' => Mage::helper('conflictchecker')->__('Used Template'),
            'align' => 'left',
            'index' => 'template_found',
        ));
        $this->addColumn('template_match', array(
            'header' => Mage::helper('conflictchecker')->__('Conflicted'),
            'align' => 'left',
            'index' => 'template_match',
            'type' => 'options',
            'options' => array(
                'true' => 'No',
                'false' => 'Yes',
                'error' => 'Error Occured with Check'
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _setCollectionOrder($column)
    {
        if ($this->getCollection() && $column) {
            $data = $this->getCollection()->getItems();
            $columnIndex = $column->getFilterIndex() ? $column->getFilterIndex() : $column->getIndex();
            Mage::register('currentSortColumn', $columnIndex);
            if (strtoupper($column->getDir()) == "ASC") {
                usort($data, function($a, $b) {
                    return strcasecmp($a->getData(Mage::registry('currentSortColumn')), $b->getData(Mage::registry('currentSortColumn')));
                });
            } else {
                usort($data, function($a, $b) {
                    return strcasecmp($b->getData(Mage::registry('currentSortColumn')), $a->getData(Mage::registry('currentSortColumn')));
                });
            }
            Mage::unregister('currentSortColumn');
            $tmp = new Varien_Data_Collection();
            foreach ($data as $item) {
                $tmp->addItem($item);
            }
            $this->setCollection($tmp);
        }
    }

    protected function _addColumnFilterToCollection($column)
    {
//        parent::_addColumnFilterToCollection($column);
        if ($this->getCollection()) {
            $field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
            $cond = $column->getFilter()->getCondition();
            if ($field && isset($cond)) {
                $tmp = new Varien_Data_Collection();
                if (array_key_exists('like', $cond)) {
                    $value = str_replace(array('%', "'"), '', $cond['like']->__toString());
                    foreach ($this->getCollection()->getItems() as $item) {
                        //var_dump($field,$value,$item,$item->getData($field),strpos($item->getData($field), $value) !== false);
                        if (strpos($item->getData($field), $value) !== false) {
                            $tmp->addItem($item);
                        }
                    }
                } elseif (array_key_exists('eq', $cond)) {
                    $value = $cond['eq'];
                    foreach ($this->getCollection()->getItemsByColumnValue($field, $value) as $filteredResult) {
                        $tmp->addItem($filteredResult);
                    }
                } else {
                    var_dump($cond);
                }
                $this->setCollection($tmp);
            }
        }
        return $this;
    }

}
