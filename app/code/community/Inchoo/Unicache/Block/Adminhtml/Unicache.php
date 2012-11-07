<?php
 
class Inchoo_Unicache_Block_Adminhtml_Unicache extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_unicache';
		$this->_blockGroup = 'unicache';
		$this->_headerText = Mage::helper('unicache')->__('Cached Data');
		parent::__construct();
		
		$this->_removeButton('add');
		
		$message = Mage::helper('core')->__('Cached data cannot be recovered after clearing the cache. Are you sure that you want to clear the cache?');
		$this->_addButton('clear_cache', array(
            'label'     => Mage::helper('unicache')->__('Clear Cache'),
            'onclick'   => "confirmSetLocation('" . $message . "', '" . $this->getClearUrl() . "')"
        ));
		
		$message = Mage::helper('core')->__('Cached data cannot be recovered after deleting. Are you sure that you want to delete expired cahce data?');
		$this->_addButton('delete_expired', array(
            'label'     => Mage::helper('unicache')->__('Delete Expired'),
            'onclick'   => "confirmSetLocation('" . $message . "', '" . $this->getDeleteExpiredUrl() . "')"
        ));
	}
	
	public function getClearUrl(){
		return $this->getUrl('*/*/clear');
	}
	
	public function getDeleteExpiredUrl(){
		return $this->getUrl('*/*/deleteExpired');
	}
}