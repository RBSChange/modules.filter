<?php
/**
 * @package modules.filter.tests
 */
abstract class filter_tests_AbstractBaseFunctionalTest extends filter_tests_AbstractBaseTest
{
	/**
	 * @return void
	 */
	public function prepareTestCase()
	{
		$this->loadSQLResource('functional-test.sql', true, false);
	}
}