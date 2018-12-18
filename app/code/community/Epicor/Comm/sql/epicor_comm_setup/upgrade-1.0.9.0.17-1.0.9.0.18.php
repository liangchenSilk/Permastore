<?php
/*
 *  upgrade script to create Access right element for Epicor_Comm 
 *Test controller 3 action added for WSO-5995
 */
$installer = $this;
$collectionAction=array('groupdelete','checkproductcount','groupdeletedownloadcsv');

foreach ($collectionAction as $colle) {
    Mage::getModel('epicor_common/access_element')->addData(array(
        'module' => 'Epicor_Comm',
        'controller' => 'Test',
        'action' => $colle,
        'action_type' =>'Access',
        'excluded' => 1,
        'portal_excluded' => 1,
    ))->save();
}
$helper = Mage::helper('epicor_common/setup');
// create default group
$group = $helper->addAccessGroup('Customer - Full Access');
// get all non-excluded elements and include them

$collection = Mage::getModel('epicor_common/access_element')->getCollection();
/* @var $collection Epicor_Common_Model_Resource_Access_Element_Collection */
$collection->addFieldToFilter('excluded',1);
$collection->addFieldToFilter('portal_excluded',1);
$right = $helper->addAccessRight('Customer - Full Access');
$helper->addAccessGroupRight($group->getId(), $right->getId());

foreach ($collection->getItems() as $element) {
    /* @var $collection Epicor_Common_Model_Access_Element */
    $helper->addAccessRightElementById($right->getId(), $element->getId());
}
$this->endSetup();