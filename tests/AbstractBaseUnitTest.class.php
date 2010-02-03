<?php
/**
 * @package modules.filter.tests
 */
abstract class filter_tests_AbstractBaseUnitTest extends filter_tests_AbstractBaseTest
{
	/**
	 * @return void
	 */
	public function prepareTestCase()
	{
		$this->resetDatabase();
	}
}