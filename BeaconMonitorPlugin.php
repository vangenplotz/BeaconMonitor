<?php
namespace Craft;

/**
 * Beacon monitor by Vangen & Plotz
 *
 * @author      Vangen & Plotz <http://vangenplotz.no>
 * @package     Beacon monitor
 * @since       Craft 2.6
 * @copyright   Copyright (c) 2017, Vangen & Plotz AS
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        https://github.com/vangenplotz/BeaconMonitor
 */

class BeaconMonitorPlugin extends BasePlugin
{

	/**
	 * @return String
	 */
	public function getName()
	{
		return Craft::t('Beacon monitor');
	}

	/**
	 * @return String
	 */
	public function getVersion()
	{
		return '0.0.1';
	}

	/**
	 * @return String
	 */
	public function getSchemaVersion()
	{
		return '0.0.1';
	}

	/**
	 * @return String
	 */
	public function getDeveloper()
	{
		return 'Vangen & Plotz AS';
	}

	/**
	 * @return String
	 */
	public function getDeveloperUrl()
	{
		return 'http://vangenplotz.no';
	}

	public function hasCpSection()
	{
		return craft()->userSession->isAdmin();
	}

	protected function defineSettings()
	{
		return array(
			'monitorSecret' => array(AttributeType::String, 'required' => true, 'default' => bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)), 'label'=> Craft::t('Secret'))
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('beaconmonitor/settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * @return String
	 */
	public function getDescription()
	{
		return Craft::t('Monitor and update multiple sites.');
	}

	public function registerSiteRoutes() {
		return array(
			'beaconmonitor/ping' => array('action' => 'beaconMonitor/ping')
		);
	}

	public function onAfterInstall()
	{
		if (!craft()->isConsole()) {
			craft()->request->redirect(UrlHelper::getCpUrl('settings/plugins/beaconmonitor'));
		}
	}

}
