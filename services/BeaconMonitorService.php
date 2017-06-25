<?php
namespace Craft;

class BeaconMonitorService extends BaseApplicationComponent
{

	// Properties
	// =========================================================================

	/**
	 * @var
	 */
	private $_siteRecordsByUrl;


	// Public Methods
	// =========================================================================

	public function getAllSites()
	{
		$criteria = new \CDbCriteria;
		$criteria->order = 'name DESC';

		return BeaconMonitor_SiteRecord::model()->findAll($criteria);
		return Array();
	}

	public function getByUrl($sUrl)
	{
		$urlHash = sha1( $sUrl );

		if (!isset($this->_siteRecordsByUrl) || !array_key_exists($urlHash, $this->_siteRecordsByUrl))
		{
			$siteRecord = BeaconMonitor_SiteRecord::model()->findByAttributes(array(
				'url' => $sUrl
			));

			if (!$siteRecord)
			{
				return false;
			}

			$this->_siteRecordsByUrl[$urlHash] = $siteRecord;
		}

		return $this->_siteRecordsByUrl[$urlHash];

	}

	public function ping($sMonitorSecret, $sUrl, $sName, $sSecret, $bAutoupdate = false)
	{
		$this->_checkMonitorSecret($sMonitorSecret);

		$sUrl = urldecode($sUrl);
		$siteRecord = $this->getByUrl($sUrl);

		if( $siteRecord )
		{
			return $this->_updateSite($siteRecord, $sUrl, $sName, $sSecret, $bAutoupdate);
		} else {
			return $this->_addSite($sUrl, $sName, $sSecret, $bAutoupdate);
		}

	}

	public function getMonitorSecret()
	{
		
		return craft()->plugins->getPlugin('beaconmonitor')->getSettings()->monitorSecret;
	}

	// Private Methods
	// =========================================================================

	private function _addSite($sUrl, $sName, $sSecret, $bAutoupdate)
	{
		$siteRecord = new BeaconMonitor_SiteRecord();
		$siteRecord->url = $sUrl;
		$siteRecord->name = $sName;
		$siteRecord->secret = $sSecret;
		$siteRecord->autoupdate = (bool)$bAutoupdate;

		return $siteRecord->save();
	}

	private function _checkMonitorSecret($sMonitorSecret)
	{

		if( $sMonitorSecret !== $this->getMonitorSecret() )
		{
			// Wrong secret!
			throw new HttpException(400);
		}
	}

	private function _updateSite($siteRecord, $sUrl, $sName, $sSecret, $bAutoupdate)
	{
		$siteRecord->url = $sUrl;
		$siteRecord->name = $sName;
		$siteRecord->secret = $sSecret;
		$siteRecord->autoupdate = (bool)$bAutoupdate;

		return $siteRecord->update();
	}

}
