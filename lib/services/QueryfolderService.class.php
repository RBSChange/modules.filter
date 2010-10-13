<?php
/**
 * filter_QueryfolderService
 * @package modules.filter
 */
class filter_QueryfolderService extends generic_FolderService
{
	/**
	 * @var filter_QueryfolderService
	 */
	private static $instance;

	/**
	 * @return filter_QueryfolderService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return filter_persistentdocument_queryfolder
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_filter/queryfolder');
	}

	/**
	 * Create a query based on 'modules_filter/queryfolder' model.
	 * Return document that are instance of modules_filter/queryfolder,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_filter/queryfolder');
	}
	
	/**
	 * Create a query based on 'modules_filter/queryfolder' model.
	 * Only documents that are strictly instance of modules_filter/queryfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_filter/queryfolder', false);
	}
	
	/**
	 * @param filter_persistentdocument_queryfolder $document
	 * @param string[] $subModelNames
	 * @param integer $locateDocumentId null if use startindex
	 * @param integer $pageSize
	 * @param integer $startIndex
	 * @param integer $totalCount
	 * @return f_persistentdocument_PersistentDocument[]
	 */
	public function getVirtualChildrenAt($document, $subModelNames, $locateDocumentId, $pageSize, &$startIndex, &$totalCount)
	{
		$queryIntersection = f_persistentdocument_DocumentFilterService::getInstance()->getQueryIntersectionFromJson($document->getQuery());
		$result = $queryIntersection->findAtOffset($startIndex, $pageSize, $totalCount);
		return $result;
	}
}