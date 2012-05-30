<?php
class Inchoo_Unicache_Helper_Data extends Mage_Core_Helper_Abstract{
		
	// Check if there is a cache entery with the specified $cache_name
	public function hasCache($cache_name){
		$cacheCollection = Mage::getModel('unicache/unicache')->getCollection()->addFilter('name', array('eq' => $cache_name));
		return ($cacheCollection->count() > 0) ? $cacheCollection->getFirstItem()->getUnicacheId() : false;
	}
	
	// Get the cache collection item with the specified $cache_name
	public function getCacheItem($cache_name){
		if($this->hasCache($cache_name)){
			$cacheCollection = Mage::getModel('unicache/unicache')->getCollection()->addFilter('name', array('eq' => $cache_name));
			return $cacheCollection->getFirstItem();
		}else{
			return NULL;
		}
	}
	
	// Check if a cache entery expired for the specified $cache_name
	public function cacheExpired($cache_name){
		$cacheItem = $this->getCacheItem($cache_name);
		if(isset($cacheItem)){
			$cacheItemTime = $cacheItem->getUpdatedTime();
			$cacheItemTimeout = $cacheItem->getCacheTimeout();
			$cacheExpireTime = strtotime("+$cacheItemTimeout hours", strtotime($cacheItemTime));
			return (time() > $cacheExpireTime);			
		}else{
			return true;
		}
	}
	
	// Check if you should use the cache content for the specified $cache_name aka check if the cache entery exists and is not expired
	public function shouldUseCache($cache_name){
		$hasCache = $this->hasCache($cache_name);
		$cacheExpired = $this->cacheExpired($cache_name);
		return ($hasCache !== false && !$cacheExpired) ? true : false;
	}
	
	// Read cached content for the specified $cache_name
	public function readCache($cache_name){
		if($this->shouldUseCache($cache_name)){
			return $this->getCacheItem($cache_name)->getContent();
		}else{
			return false;
		}
	}
	
	// Create a cache entery for the specified $cache_name using $content and $cache_timeout.
	public function writeCache($cache_name, $content, $cache_timeout = NULL){
		$cacheItem = $this->getCacheItem($cache_name);
		if(isset($cacheItem)){
			if(!isset($cache_timeout)) $cache_timeout = $cacheItem->getCacheTimeout();
			$cacheItem->setName($cache_name)
				 ->setContent($content)
				 ->setUpdatedTime(date('Y-m-d H:i:s'))
				 ->setCacheTimeout($cache_timeout)
			->save();
		}else{
			if(!isset($cache_timeout)) $cache_timeout = 24;
			Mage::getModel('unicache/unicache')
				->setName($cache_name)
				->setContent($content)
				->setUpdatedTime(date('Y-m-d H:i:s'))
				->setCacheTimeout($cache_timeout)
			->save();
		}
	}
	
	// Delete a cache entery specified by $cache_name
	public function deleteCache($cache_name = NULL){
		if(isset($cache_name) && !empty($cache_name)){
			$cacheItem = $this->getCacheItem($cache_name);
			if(isset($cacheItem)) $cacheItem->delete();
		}else{
			$cacheData = Mage::getModel('unicache/unicache')->getCollection();
			foreach($cacheData as $cacheItem){
				$cacheItem->delete();
			}
		}
	}
	
	// Get the cache timeout value for the specified $cache_name
	public function cacheTimeout($cache_name){
		$cacheItem = $this->getCacheItem($cache_name);
		return (isset($cacheItem)) ? $cacheItem->getCacheTimeout() : false;
	}
	
	// Change only the cache timeout ofr the specified $cache_name
	public function updateCacheTimeout($cache_name, $cache_timeout){
		$cacheItem = $this->getCacheItem($cache_name);
		if(isset($cacheItem)) $cacheItem->setCacheTimeout($cache_timeout)->save();
	}
	
}