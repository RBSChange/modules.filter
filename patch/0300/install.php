<?php
/**
 * filter_patch_0300
 * @package modules.filter
 */
class filter_patch_0300 extends patch_BasePatch
{
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		$this->executeModuleScript('init.xml', 'filter');
	}

	/**
	 * @return String
	 */
	protected final function getModuleName()
	{
		return 'filter';
	}

	/**
	 * @return String
	 */
	protected final function getNumber()
	{
		return '0300';
	}
}