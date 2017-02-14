<?php
namespace Ktpl\Brand\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.1.0') < 0) {
             $tableName = $setup->getConnection()->newTable(
                    $setup->getTable('brand_product')
                )->addColumn(
                    'rel_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
                    'Entity ID'
                )->addColumn(
                    'brand_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => false, 'unsigned' => true, ],
                    'Brand ID'
                )->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [ 'nullable' => false, 'unsigned' => true, ],
                    'Product ID'
                );
                    $setup->getConnection()->createTable($tableName);
                    //$setup->endSetup();
        }
        $setup->endSetup();
    }
}