<?php
/**
 * Author: joy.zhu
 * Email: fifteenjoy@gmail.com
 */
?>
<?php
class Joy_Optionimage_Adminhtml_Attribute_Option_ImageController extends Mage_Adminhtml_Controller_Action
{

    protected $_entityTypeId = 4;

    public function indexAction()
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Manage Attribute Option images'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('catalog/resource_eav_attribute')
            ->setEntityTypeId($this->_entityTypeId);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('joy_optionimage')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('catalog')->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($this->__('Catalog'))
            ->_title($this->__('Edit Attribute Option images'));
        Mage::register('attribute_id', $id);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {

        $attribute_id = $this->getRequest()->getParam('attribute_id');
        $redirectBack = $this->getRequest()->getParam('back', false);

        // delete image
        $data = $this->getRequest()->getParam('data');
        if($data) {
            foreach ($data as $option_id => $v) {
                foreach ($v as $store_id => $sub_v) {
                    if (isset($sub_v['delete']) && $sub_v['delete'] == 1) {
                        $image = Mage::getModel("joy_optionimage/attribute_option_image")->loadByOptionIdAndStoreId($option_id, $store_id);
                        if ($image->getId()) $image->delete();
                    }
                }
            }
        }
        unset($option_id);
        unset($store_id);

        // upload and save image
        $data = isset($_FILES['data']) ? $_FILES['data'] : array();
        if($data) {
            foreach ($data['name'] as $option_id => $sub_v) {
                foreach ($sub_v as $store_id => $picname) {
                    if ($picname) {
                        $type = $data['type'][$option_id][$store_id];
                        $tmp_name = $data['tmp_name'][$option_id][$store_id];
                        $_FILES = array();
                        $_FILES[$option_id . "-" . $store_id] = array(
                            'name' => $picname,
                            'type' => $type,
                            'tmp_name' => $tmp_name
                        );
                        try {
                            $result = $this->uploadImage($option_id . "-" . $store_id);
                            $model = Mage::getModel("joy_optionimage/attribute_option_image")->loadByOptionIdAndStoreId($option_id, $store_id);
                            $model->addData(
                                array(
                                    "option_id" => $option_id,
                                    "store_id" => $store_id,
                                    "image" => $result['file'],
                                )
                            )->save();
                        } catch (Exception $e) {
                            Mage::getSingleton('adminhtml/session')->addException($e, $e->getMessage());
                        }

                    }
                }
            }
        }

        if ($redirectBack) {
            $this->_redirect('*/*/edit', array(
                'attribute_id' => $attribute_id,
                '_current' => true
            ));
        } else {
            $this->_redirect('*/*/');
        }
    }

    /*
     * Upload image handle
     */
    protected function uploadImage($fileid)
    {

        $uploader = new Varien_File_Uploader($fileid);
        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $path = Mage::getBaseDir('media') . DS . 'optionimage/';
        $result = $uploader->save($path, $_FILES[$fileid]['name']);
        if (!$result) {
            throw new Exception("Error occur when uploadding image");
        }
        return $result;

    }
    
}

?>