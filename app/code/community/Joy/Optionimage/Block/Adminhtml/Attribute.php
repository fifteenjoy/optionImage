<?php
class Joy_Optionimage_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Template
{
    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('joy/optionimage/attribute.phtml');
    }
    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Prepare button and grid
     *
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('joy_optionimage/adminhtml_attribute_grid', 'dropdownattribute.grid'));
        return parent::_prepareLayout();
    }

}