<?php

class Epicor_FlexiTheme_Block_Adminhtml_Layout_Block_Callout_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_layout_block_callout';
        $this->_blockGroup = 'flexitheme';
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    public function getHeaderText()
    {
        if (Mage::registry('layout_block_data') && Mage::registry('layout_block_data')->getId()) {
            $title = Mage::registry('layout_block_data')->getBlockName();
             $header_text= Mage::helper('adminhtml')->__('Edit Callout Block "%s"', $this->htmlEscape($title));
        } else {
            $header_text =  Mage::helper('adminhtml')->__('New Callout Block');
        }
        
        return $header_text;
    }

}