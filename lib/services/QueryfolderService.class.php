<?php
/**
 * @package modules.filter
 * @method filter_QueryfolderService getInstance()
 */
class filter_QueryfolderService extends generic_FolderService
{
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
		return $this->getPersistentProvider()->createQuery('modules_filter/queryfolder');
	}
	
	/**
	 * Create a query based on 'modules_filter/queryfolder' model.
	 * Only documents that are strictly instance of modules_filter/queryfolder
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_filter/queryfolder', false);
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