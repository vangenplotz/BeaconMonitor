<?php
namespace Craft;

class BeaconMonitorVariable
{
	public function getSites()
	{
		return craft()->beaconMonitor->getAllSites();
	}

	public function getSecret()
	{
		return craft()->beaconMonitor->getMonitorSecret();
	}
}