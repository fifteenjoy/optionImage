<?php
class Joy_Optionimage_Block_Adminhtml_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('attributeGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');

    }
    /**
     * Prepare default grid column
     *
     * @return Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumn('attribute_code', array(
            'header' => Mage::helper('eav')->__('Attribute Code'),
            'sortable' => true,
            'index' => 'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header' => Mage::helper('eav')->__('Attribute Label'),
            'sortable' => true,
            'index' => 'frontend_label'
        ));
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/product_attribute_collection');

        // Add has option filter
        $adapter = $collection->getConnection();
        $collection->getSelect()
            ->joinLeft(
                array('ao' => $collection->getTable('eav/attribute_option')),
                'ao.attribute_id = main_table.attribute_id',
                'option_id')
            ->group('main_table.attribute_id')
            ->where($adapter->quoteInto('(main_table.frontend_input = ? AND ao.option_id > 0)', 'select'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * Return url of given row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('attribute_id' => $row->getAttributeId()));
    }
}