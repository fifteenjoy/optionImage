<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
class Joy_Optionimage_Model_Resource_Attribute_Option_Image extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table and initialize connection
     *
     */
    protected function _construct()
    {
        $this->_init('joy_optionimage/attribute_option_image', 'image_id');
    }

    /**
     * Get image identifier/object by Option Id And Store Id
     * @param  $option_id
     * @param  $store_id
     * @param  $column
     * @return string
     */
    public function getImageByOptionIdAndStoreId($option_id,$store_id,$column = 'image')
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->getMainTable(), $column)
            ->where('option_id = :option_id')
            ->where('store_id = :store_id');

        $bind = array(
            ':option_id' => $option_id,
            ':store_id' => $store_id
        );

        return $adapter->fetchOne($select, $bind);


    }

    public function loadByOptionIdAndStoreId($image,$option_id,$store_id)
    {
        $image_id = $this->getImageByOptionIdAndStoreId($option_id,$store_id,$this->_idFieldName);
        if($image_id) {
            $this->load($image, $image_id);
        } else {
            $image->setData(array());
        }
        return $this;
    }



}
?>