<?php
class Joy_Optionimage_Block_Adminhtml_Attribute_Option_Image_Edit_Form_Content extends Mage_Adminhtml_Block_Template
{
    protected $_optionImageData = array();

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('joy/optionimage/attribute/option/image/form/content.phtml');
    }

    protected function prepareAttributeOptionImageData($option_ids)
    {
        if(!is_array($option_ids)) $option_ids = array($option_ids);
        $collection = Mage::getResourceModel('joy_optionimage/attribute_option_image_collection')
                ->setOptionFilter($option_ids);
        foreach($collection as $item) {
            $this->_optionImageData[] = $item->getData();
        }
        return $this->_optionImageData;
    }
    /*
     * Get Options values for all store
     */
    public function getOptionValues()
    {

        $values = $this->getData('option_values');
        if (is_null($values)) {

            $option_data = Mage::getResourceModel('joy_optionimage/attribute_option_image_collection')
                ->setAttributeFilter(Mage::registry('attribute_id'));
            $values = array();
            $option_data = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter(Mage::registry('attribute_id'))
                ->setPositionOrder('desc', true)
                ->toOptionArray();

            // restructure option_data
            $data = array();
            foreach($option_data as $v) {
                $data[] = $v['value'];
            }
            unset($option_data);
            $this->prepareAttributeOptionImageData($data);
            $helper = Mage::helper('core');
            foreach ($data as $v) {
                $value = array();
                $value['id'] = $v;
                $value['data'] = array();
                foreach ($this->getStores() as $store) {
                    $optionImageData = $this->getOptionImageData($v,$store->getId());
                    $storeValues = $this->getStoreOptionValues($store->getId());
                    $value['data'][$store->getId()]['storecode'] = $store->getCode();
                    $value['data'][$store->getId()]['image'] = isset($optionImageData['image']) ? $optionImageData['image'] : '' ;
                    $value['data'][$store->getId()]['label'] = isset($storeValues[$v])
                        ? $helper->escapeHtml($storeValues[$v]) : '';
                }
                $value['fieldset_id'] =  $store->getId()."-".$v;

                $values[]= new Varien_Object($value);
            }
            $this->setData('option_values', $values);
        }
        return $values;
    }



    /*
     * Get Option Image by option id and storeid
     */
    protected function getOptionImageData($optionid, $storeid)
    {
        foreach($this->_optionImageData as $k=>$v) {
            if($v['option_id'] == $optionid && $v['store_id'] == $storeid && $v['image']) {
                $v['image'] = Mage::helper('joy_optionimage')->getAttributeOptionImageFullUrl($v['image']);
                return $v;
            }
        }
        return false;
    }
    
    public function getStores()
    {
        $stores = $this->getData('stores');
        if (is_null($stores)) {
            $stores = Mage::getModel('core/store')
                ->getResourceCollection()
                ->setLoadDefault(true)
                ->load();
            $this->setData('stores', $stores);
        }
        return $stores;
    }

    /**
     * Retrieve attribute option values for given store id
     *
     * @param integer $storeId
     * @return array
     */
    public function getStoreOptionValues($storeId)
    {
        $values = null;
        $values = $this->getData('store_option_values_'.$storeId);
        if (is_null($values)) {
            $values = array();
            $valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter(Mage::registry('attribute_id'))
                ->setStoreFilter($storeId, false);
            foreach ($valuesCollection as $item) {
                $values[$item->getId()] = $item->getValue();
            }
            $this->setData('store_option_values_'.$storeId, $values);
        }
        return $values;
    }
}
?>