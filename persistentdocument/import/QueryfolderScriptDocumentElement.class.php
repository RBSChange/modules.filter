<?php
/**
 * filter_QueryfolderScriptDocumentElement
 * @package modules.filter.persistentdocument.import
 */
class filter_QueryfolderScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return filter_persistentdocument_queryfolder
     */
    protected function initPersistentDocument()
    {
    	return filter_QueryfolderService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_filter/queryfolder');
	}

	/**
	 * @return array
	 */
	protected function getDocumentProperties()
	{
		$properties = parent::getDocumentProperties();
		if (isset($properties['query']))
		{
			$query = $this->replaceRefIdInString($properties['query']) ;
			$properties['query'] = $query;
		}
		return $properties;
	}
}