<?php
class Inchoo_Unicache_Block_Adminhtml_Unicache_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('UnicacheGrid');
		$this->setDefaultSort('unicache_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
 
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('unicache/unicache')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
 
	protected function _prepareColumns()
	{
		$this->addColumn('unicache_id', array(
			'header'    => Mage::helper('unicache')->__('ID'),
			'align'     =>'right',
			'width'     => '50px',
			'index'     => 'unicache_id',
		));
 
		$this->addColumn('name', array(
			'header'    => Mage::helper('unicache')->__('Name'),
			'align'     =>'left',
			'index'     => 'name',
		));
		
		$this->addColumn('content', array(
			'header'    => Mage::helper('unicache')->__('Content'),
			'align'     =>'left',
			'index'     => 'content',
		));
		
		$this->addColumn('updated_time', array(
			'header'    => Mage::helper('unicache')->__('Updated'),
			'align'     =>'left',
			'width'     => '150px',
			'index'     => 'updated_time',
		));
		
		$this->addColumn('cache_timeout', array(
			'header'    => Mage::helper('unicache')->__('Timeout'),
			'align'     =>'left',
			'width'     => '100px',
			'index'     => 'cache_timeout',
		));
 
		return parent::_prepareColumns();
	}
 
	public function getRowUrl($row)
	{
		return NULL;
	}
 
	public function getGridUrl()
	{
	  return $this->getUrl('*/*/grid', array('_current'=>true));
	}
 
 
}