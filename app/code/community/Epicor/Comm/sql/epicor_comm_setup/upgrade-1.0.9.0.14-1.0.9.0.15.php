<?php

/**
 * Version 1.0.9.0.14 - 1.0.9.0.15 upgrade to save the config value for 
 * epicor_comm_field_mapping/cus_mapping/delete_contacts_when_delete_erpaccount
 *
 */
$installer = $this;
$installer->startSetup();
/* getting value from collection Since storeConfig function is getting empty value in upgrade */
$savedErpSystem = Mage::getResourceModel('core/config_data_collection')->addFieldToFilter('path', 'Epicor_Comm/licensing/erp')->getFirstItem()->getValue();
//Mage::getStoreConfig('Epicor_Comm/licensing/erp');
if ($savedErpSystem == 'e10') {
    Mage::getConfig()->saveConfig('epicor_comm_field_mapping/cus_mapping/delete_contacts_when_delete_erpaccount', 0, 'default', 0);
} else {
    Mage::getConfig()->saveConfig('epicor_comm_field_mapping/cus_mapping/delete_contacts_when_delete_erpaccount', 1, 'default', 0);
}
$installer->endSetup();
