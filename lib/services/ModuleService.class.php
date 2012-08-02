<?php
/**
 * @package modules.filter.lib.services
 */
class filter_ModuleService extends ModuleBaseService
{
	/**
	 * Singleton
	 * @var filter_ModuleService
	 */
	private static $instance = null;

	/**
	 * @return filter_ModuleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
	
}