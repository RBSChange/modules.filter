<?php
/**
 * @package modules.filter.lib
 */
class filter_StaticQuery
{
	/**
	 * @var f_persistentdocument_PersistentDocumentModel
	 */
	private $documentModel;
	
	/**
	 * @var integer[]
	 */
	private $ids = array();

	/**
	 * @param integer[] $ids
	 */
	public function __construct($documentModel, $ids)
	{
		$this->documentModel = $documentModel;
		$this->ids = $ids;
	}
	
	/**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	public function getDocumentModel()
	{
		return $this->documentModel;
	}
	
	/**
	 * @return integer[]
	 */
	public function getIds()
	{
		return $this->ids;
	}
}