<?php

/*
 *  upgrade script to create Access right element for sales module
 * Since we have overridded the Mage Sales controller
 */
$installer = $this;
$collection = Mage::getModel('epicor_common/access_element')->getCollection()
        ->addFieldToFilter('module', 'Mage_Sales')
        ->addFieldToFilter('controller', array('in' => array('Order', '*')));
foreach ($collection as $colle) {
    Mage::getModel('epicor_common/access_element')->addData(array(
        'module' => 'Epicor_Comm',
        'controller' => $colle->getController(),
        'action' => $colle->getAction(),
        'block' => $colle->getBlock(),
        'action_type' => $colle->getActionType(),
        'excluded' => $colle->getExcluded(),
        'portal_excluded' => $colle->getPortalExcluded(),
    ))->save();
}
$helper = Mage::helper('epicor_common/setup');
// create default group
$group = $helper->addAccessGroup('Customer - Full Access');
// get all non-excluded elements and include them

$collection = Mage::getModel('epicor_common/access_element')->getCollection();
/* @var $collection Epicor_Common_Model_Resource_Access_Element_Collection */
$collection->addFieldToFilter('excluded', 0);
$right = $helper->addAccessRight('Customer - Full Access');
$helper->addAccessGroupRight($group->getId(), $right->getId());

foreach ($collection->getItems() as $element) {
    /* @var $collection Epicor_Common_Model_Access_Element */
    $helper->addAccessRightElementById($right->getId(), $element->getId());
}
$this->endSetup();
