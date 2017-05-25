<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
class Joy_Optionimage_Helper_Data extends Mage_Core_Helper_Abstract
{
    /*
     * Get option image full url
     */
    public function getAttributeOptionImageFullUrl($image) {
        $path = Mage::getConfig()->getNode("global/attribute/option/image_dir")->asArray();
        if($path && file_exists(Mage::getBaseDir("media") . DS . $path . DS . $image)) {
            return Mage::getBaseUrl("media") . $path . DS . $image;
        } else {
            return false;
        }

    }

    public function getOptionImage($option_id,$attribute = null) {
        if($attribute) {
            $collection = Mage::getResourceModel('joy_optionimage/attribute_option_image_collection')
                ->setAttributeFilter($attribute);
            // set collection cache
            if (Mage::app()->useCache('collections')) {
                $collection->initCache(Mage::app()->getCache(), 'joy_optionimage_attribute_option_image_for_attribute_' . $attribute . "_0", array('COLLECTION_DATA'));
            }
        } else {
            $collection = Mage::getResourceModel('joy_optionimage/attribute_option_image_collection')
                ->setOptionFilter($option_id);
        }
        $image = null;
        $defaultImage = null;
        $defaultLabel = null;
        foreach($collection as $v) {
            if($v['option_id'] != $option_id) continue;
            if ($v['store_id'] == 0) {
                $defaultImage = $v['image'];
            }
            if ($v['store_id'] == Mage::app()->getStore()->getId()) {
                $image = $v['image'];
            }
        }
        // use admin store image if image for current store_view is not defined
        if (!$image && $defaultImage) $image = $defaultImage;
        if ($image && $imageUrl=$this->getAttributeOptionImageFullUrl($image)) {
            $html = "<img style=\"width:30px;height:30px;display: inline-block;\" src=\"{$imageUrl}\" />";

            return $html;
        }
        return '';

    }
   
}
	
?>