<?php
namespace Craft;

class BeaconMonitorController extends BaseController
{
	protected $allowAnonymous = array('actionPing');

	public function actionPing()
	{
		$sMonitorSecret = craft()->request->getRequiredParam('monitorSecret');

		$sName = craft()->request->getRequiredParam('siteName');
		$sSecret = craft()->request->getRequiredParam('siteSecret');
		$bAutoupdate = craft()->request->getParam('autoupdate');
		$sUrl = craft()->request->getRequiredParam('siteUrl');

		$result = craft()->beaconMonitor->ping($sMonitorSecret, $sUrl, $sName, $sSecret, $bAutoupdate);

		$this->returnJson( $result );
	}
}
