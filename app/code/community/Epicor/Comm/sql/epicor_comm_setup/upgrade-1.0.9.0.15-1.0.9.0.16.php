<?php
/*
 *  upgrade script to create ERP account is_invoice_selection attribute
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$this->startSetup();
$conn = $installer->getConnection();
/* @var $conn Varien_Db_Adapter_Pdo_Mysql */

/*Create an ERP customer account attribute tax_exempt_reference*/
$table = $installer->getTable('epicor_comm/erp_customer_group');
if (!$conn->tableColumnExists($table, 'is_invoice_edit')) {
    $conn->addColumn($table, 'is_invoice_edit', array(
        'nullable' => true,
        'unsigned' => true,
        'primary' => false,
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 1,
        'comment' => 'AR Payments Invoice Edit Allowed, 2: Global Default, 0: No, 1: Yes',
        'default' => 2
    ));
}

$this->endSetup();