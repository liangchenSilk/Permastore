<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckController
 *
 * @author Paul.Ketelle
 */
class Epicor_ConflictChecker_Adminhtml_Conflictchecker_CheckController extends Mage_Adminhtml_Controller_Action
{
    public function templatesAction()
    {
        $this->_title($this->__('ECC Template Checker'));
        $this->loadLayout();
        $this->_setActiveMenu('epicor_common/conflictchecker');
        $this->_addBreadcrumb(Mage::helper('conflictchecker')->__('ECC Template Checker'), Mage::helper('conflictchecker')->__('ECC Template Checker'));
        $this->renderLayout();
        
        
    }
    
    public function testAction()
    {
        echo '<pre>';
            $helper = Mage::helper('conflictchecker');
            /* @var $helper Epicor_ConflictChecker_Helper_Data */
            $conflicts = $helper->getConflictedTemplates();
            echo '<h1> Overridding Templates ('.count($conflicts).')</h1>';
        print_r($conflicts);
        $results = $helper->getComparedTemplateDataCollection();
        
            echo '<h1> Complete List of Templates</h1>';
        print_r($results->getItemsByColumnValue('reference', 'content'));
        exit;
        
    }
}
