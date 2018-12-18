<?php

class Epicor_Common_Block_Adminhtml_Access_Admin_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'admin_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post'
                )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}