<?php
class Inchoo_Unicache_Model_Unicache extends Mage_Core_Model_Abstract{
	
	public function _construct(){
		parent::_construct();
		$this->_init('unicache/unicache');
	}
	
}