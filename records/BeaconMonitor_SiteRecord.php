<?php
namespace Craft;

class BeaconMonitor_SiteRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'beaconmonitor_sites';
	}

	public function defineAttributes()
	{
		return array(
			'name' => array(AttributeType::String, 'required' => true),
			'url' => array(AttributeType::Url, 'required' => true),
			'secret' => array(AttributeType::String, 'required' => true),
			'autoupdate' => array(AttributeType::Bool, 'default' => false)
		);
	}

	public function defineIndexes()
	{
		return array(
			array('columns' => array('name', 'autoupdate'), 'unique' => false)
		);
	}
}
