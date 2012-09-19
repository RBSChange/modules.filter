<?php
/**
 * @package modules.filter.setup
 */
class filter_Setup extends object_InitDataSetup
{
	public function install()
	{
		$this->executeModuleScript('init.xml');
	}
}