# optionImage
optionImage extension is used to manage optionImage in magento backend
Once install, it is easy to fetch option image by call  Mage::helper('joy_optionimage')->getOptionImage($option_id)
eg:Mage::helper('joy_optionimage')->getOptionImage(43)

One scenario about optionImage is to show image in left filter instead of label text.

In app/design/frontend/rwd/default/template/catalog/layer/filter.phtml template
<ol>
<?php foreach ($this->getItems() as $_item): ?>
    <li>
        <?php if ($_item->getCount() > 0): ?>
            <a href="<?php echo $this->urlEscape($_item->getUrl()) ?>">

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
                ?>
                <?php if ($this->shouldDisplayProductCount()): ?>
                <span class="count">(<?php echo $_item->getCount() ?>)</span>
                <?php endif; ?>
            </a>
        <?php else: ?>
            <span>
                <?php echo $_item->getLabel(); ?>
                <?php if ($this->shouldDisplayProductCount()): ?>
                    <span class="count">(<?php echo $_item->getCount() ?>)</span>
                <?php endif; ?>
            </span>
        <?php endif; ?>
    </li>
<?php endforeach ?>
</ol>