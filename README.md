# optionImage
![backend](https://cloud.githubusercontent.com/assets/5753892/26443857/a3b3c902-416c-11e7-8d6b-c48f6282b9ab.png)
![attribute list](https://cloud.githubusercontent.com/assets/5753892/26443869/b8628fc8-416c-11e7-92f4-69a26a8e5c5d.png)
![optionimage](https://cloud.githubusercontent.com/assets/5753892/26443891/ca3455ba-416c-11e7-9438-bdd03656f385.png)
optionImage extension is used to manage optionImage in storeview scope in magento backend.
if option image is not setted for specified store, then image for admin(store id is 0) will be used.

Once install, it is easy to fetch option image by call  Mage::helper('joy_optionimage')->getOptionImage($option_id)
eg:Mage::helper('joy_optionimage')->getOptionImage(43)

One scenario about optionImage is to show image in left filter instead of label text.

In app/design/frontend/rwd/default/template/catalog/layer/filter.phtml template

                <?php
                if($_item->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Attribute) {
                    // change start, show option image
                    $attribute_id = $_item->getFilter()->getAttributeModel()->getId();
                    if($image = Mage::helper('joy_optionimage')->getOptionImage($_item->getValue(),$attribute_id)) {
                        echo $image;
                    } else {
                        echo $_item->getLabel();
                    }
                    // change end
                } else {
                     echo $_item->getLabel();
                }

