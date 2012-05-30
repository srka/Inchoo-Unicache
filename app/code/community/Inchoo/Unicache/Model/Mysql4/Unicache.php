<?php
class Inchoo_Unicache_Model_Mysql4_Unicache extends Mage_Core_Model_Mysql4_Abstract{
	
	public function _construct(){
		$this->_init('unicache/unicache', 'unicache_id');
	}
	
}