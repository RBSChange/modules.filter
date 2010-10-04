<?php
/**
 * filter_patch_0301
 * @package modules.filter
 */
class filter_patch_0301 extends patch_BasePatch
{
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		$this->execChangeCommand('compile-locales', array('filter'));
		$this->executeLocalXmlScript('lists.xml');
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
		return '0301';
	}
}