<?php
class Joy_Optionimage_Model_Resource_Attribute_Option_Image_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('joy_optionimage/attribute_option_image');
     }

    /**
     * Set attribute filter
     *
     * @param int|string  $attribute
     * @parambool $use_label
     * @return Joy_Optionimage_Model_Resource_Attribute_Option_Image_Collction
     */
    public function setAttributeFilter($attribute,$use_default_value=false) {

        if(!is_numeric($attribute)) {
            $attribute = Mage::getModel("eav/entity_attribute")->getIdByCode(Mage_Catalog_Model_Product::ENTITY,$attribute);
        }

        $adapter = $this->getConnection();

        $joinCondition = $adapter->quoteInto('eao.option_id = main_table.option_id and eao.attribute_id = ?', $attribute);

        $this->getSelect()
            ->join(
                array('eao'=>Mage::getSingleton('core/resource')->getTableName('eav/attribute_option')),
                $joinCondition,
                'attribute_id'
    );
        if ($use_default_value) {
            $this->getSelect()
                ->joinLeft(
                    array('tsv' =>  Mage::getSingleton('core/resource')->getTableName('eav/attribute_option_value')),
                    'tsv.option_id = main_table.option_id and tsv.store_id = 0',
                    array('default_label' => 'value'));
        }

            $this->getSelect()
                ->joinLeft(
                    array('tdv' => Mage::getSingleton('core/resource')->getTableName('eav/attribute_option_value')),
                    'tdv.option_id = main_table.option_id and tdv.store_id = main_table.store_id',
                    array('option_label' => 'value'));

        return $this;
    }
    /**
     * Set option filter
     *
     * @param array $option_ids
     * @param bool $use_label
     * @return Joy_Optionimage_Model_Resource_Attribute_Option_Image_Collction
     */
    public function setOptionFilter(array $option_ids, $use_default_value=false)
    {
        $this->addFieldToFilter('main_table.option_id', array('in' => $option_ids));
        if ($use_default_value) {
            $this->getSelect()
                ->joinLeft(
                    array('tsv' =>  Mage::getSingleton('core/resource')->getTableName('eav/attribute_option_value')),
                    'tsv.option_id = main_table.option_id and tsv.store_id = 0',
                    array('default_label' => 'value'));
    }

            $this->getSelect()
                ->joinLeft(
                    array('tdv' => Mage::getSingleton('core/resource')->getTableName('eav/attribute_option_value')),
                    'tdv.option_id = main_table.option_id and tdv.store_id = main_table.store_id',
                    array('option_label' => 'value'));

        return $this;

    }
}
?>