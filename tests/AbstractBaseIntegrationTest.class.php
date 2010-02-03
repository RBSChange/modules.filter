<?php
/**
 * @package modules.filter.tests
 */
abstract class filter_tests_AbstractBaseIntegrationTest extends filter_tests_AbstractBaseTest
{
	/**
	 * @return void
	 */
	public function prepareTestCase()
	{
		$this->loadSQLResource('integration-test.sql', true, false);
	}
}