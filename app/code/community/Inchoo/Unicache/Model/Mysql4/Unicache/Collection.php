<?php
class Inchoo_unicache_Model_Mysql4_Unicache_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
	
	public function _construct(){
		parent::_construct();
		$this->_init('unicache/unicache');
	}
	
}