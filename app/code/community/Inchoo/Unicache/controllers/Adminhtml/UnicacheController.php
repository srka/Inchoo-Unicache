<?php
class Inchoo_Unicache_Adminhtml_UnicacheController extends Mage_Adminhtml_Controller_Action
{
	
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }
 
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('unicache/items');
        return $this;
    }
	
	public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('unicache/adminhtml_unicache'));
        $this->renderLayout();
    }
	
	public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('unicache/adminhtml_unicache_grid')->toHtml()
        );
    }
	
	public function clearAction(){
		Mage::helper('unicache')->deleteCache();
        $this->_getSession()->addSuccess(Mage::helper('unicache')->__("Cached data has been cleared."));
        $this->_redirect('*/*');
	}
	
	public function deleteExpiredAction(){
		$message = Mage::helper('unicache')->deleteExpired();
        $this->_getSession()->addSuccess(Mage::helper('unicache')->__($message));
        $this->_redirect('*/*');
	}
}