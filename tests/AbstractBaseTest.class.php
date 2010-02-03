<?php
/**
 * @package modules.filter.tests
 */
abstract class filter_tests_AbstractBaseTest extends f_tests_AbstractBaseTest
{
	/**
	 * @return String
	 */
	protected final function getPackageName()
	{
		return 'modules_filter';
	}

	/**
	 * @return void
	 */
	protected function clearServicesCache()
	{
		parent::clearServicesCache();
		RequestContext::clearInstance();
		self::clearModuleServiceCache();
	}

	/**
	 * @return void
	 */
	public static function clearModuleServiceCache()
	{
		// Call here methods to clear caches in services.
	}
}