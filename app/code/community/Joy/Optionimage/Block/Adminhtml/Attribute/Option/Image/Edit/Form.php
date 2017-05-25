<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
/**
 *  attribute option image edit form
 *
 */

class Joy_Optionimage_Block_Adminhtml_Attribute_Option_Image_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareLayout()
    {
            // add child block
            $this->setChild("joy_optionimage_attribute_option_content",
                $this->getLayout()->createBlock('joy_optionimage/adminhtml_attribute_option_image_edit_form_content')
            );

        return parent::_prepareLayout();
    }
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setUseContainer(false);
        $form->setData("enctype","multipart/form-data");
        $this->setForm($form);
        return parent::_prepareForm();
    }



    /*
     * rewrite form html, add attribuge option html code to form
     */
    public function getFormHtml()
    {

        if (is_object($this->getForm())) {
            $form = $this->getForm();
            $html = '';
            $html .= '<form '.$form->serialize($form->getHtmlAttributes()).'>';
            $html .= '<div>';
            if (strtolower($form->getData('method')) == 'post') {
                $html .= '<input name="form_key" type="hidden" value="'.Mage::getSingleton('core/session')->getFormKey().'" />';
            }
            $html .= '</div>';
            $html .=  $this->getForm()->getHtml();
            // option value
            $html .= $this->getChildHtml("joy_optionimage_attribute_option_content");

            $html.= '</form>';
            return $html;
        }
        return '';
    }
}
