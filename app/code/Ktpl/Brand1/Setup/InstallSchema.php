<?php
namespace Ktpl\Brand\Setup;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        //START: install stuff
        //END:   install stuff
        
//START table setup
$table = $installer->getConnection()->newTable(
            $installer->getTable('brand')
    )->addColumn(
            'brand_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
            'Entity ID'
        )->addColumn(
            'brand_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [ 'nullable' => false, ],
            'Title'
        )->addColumn(
            'brand_url',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [ 'nullable' => false, ],
            'Url'
        )->addColumn(
            'brand_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [ 'nullable' => false, ],
            'Image'
        )->addColumn(                
            'date_completed',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            array (
  'nullable' => true,
),
            'Date the item was completed'
 )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT, ],
            'Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE, ],
            'Modification Time'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            [ 'nullable' => false, 'default' => '1', ],
            'Is Active'
        );
$installer->getConnection()->createTable($table);
//END   table setup
$installer->endSetup();
    }
}
