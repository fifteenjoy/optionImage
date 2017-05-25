<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
/**
 * Create table 'joy_optionimage/attribute_option_image'
 */
$installer = $this;
$installer->getConnection()->dropTable($installer->getTable('joy_optionimage/attribute_option_image'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('joy_optionimage/attribute_option_image'))
    ->addColumn('image_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Image Id')
    ->addColumn('option_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Option Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'default'   => 0,
        'nullable'  => false,
    ), 'Store Id')
    ->addColumn('image',  Varien_Db_Ddl_Table::TYPE_TEXT, 50,  array(
        'nullable'  => true,
        'default'   => null,
    ), 'Image')
    ->addIndex($installer->getIdxName(
        'joy_optionimage/attribute_option_image',
        array('option_id','store_id'),
        Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    ),
        array('option_id','store_id'),
        array('type'=>Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('joy_optionimage/attribute_option_image', 'option_id','eav/attribute_option', 'option_id' ),
        'option_id', $installer->getTable('eav/attribute_option'), 'option_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('joy_optionimage/attribute_option_image', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Attribute Option Image');
$installer->getConnection()->createTable($table);
