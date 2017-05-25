<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
class Joy_Optionimage_Model_Attribute_Option_Image extends Mage_Core_Model_Abstract{

    protected function _construct()
    {
        return $this->_init("joy_optionimage/attribute_option_image");

    }

    /*
     * Load image by OptionId and store
     */
    public function loadByOptionIdAndStoreId($option_id,$store_id)
    {
        $this->getResource()->loadByOptionIdAndStoreId($this,$option_id,$store_id);
        return $this;
    }

    
    public function getOptionImage($optionid) {
        
    }
  
}
?>