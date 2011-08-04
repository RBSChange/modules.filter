<?php
/**
 * generic_GetDocumentFilterInfoAction
 * @package modules.filter.actions
 */
class filter_GetDocumentQueryInfoAction extends change_JSONAction
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		
		$result = array();
		$infoAsJson = $request->getParameter('infoAsJson');
		if ($infoAsJson)
		{
			$info = JsonService::getInstance()->decode($infoAsJson);
			$dfs = f_persistentdocument_DocumentFilterService::getInstance();
			if (isset($info["elements"]))
			{
				$filters = $dfs->getFilterArrayFromJson($info["elements"]);
			}
			else
			{
				// filter <= 3.0.2 compatibility
				$filters = $dfs->getFilterArrayFromJson($info);
			}
			foreach ($filters as $filter)
			{
				$filterInfo = array();
				$this->addFilter($filterInfo, $filter);
				$result[] = $filterInfo;
			}
		}
		
		return $this->sendJSON($result);
	}
	
	private function addFilter(&$filterInfo, $filter)
	{
		if (is_object($filter))
		{
			$filterInfo['class'] = get_class($filter);
			$filterInfo['label'] = $filter->getLabel();
			$filterInfo['text'] = $filter->getText();
			$filterInfo['textWithMarkers'] = $filter->getText(true);
		}
		else
		{
			$filterInfo['class'] = 'filterSection';
			$sectionFilters = array();
			foreach ($filter as $f)
			{
				$sectionFilterInfo = array();
				$this->addFilter($sectionFilterInfo, $f);
				$sectionFilters[] = $sectionFilterInfo;
			}
			$filterInfo['filters'] = $sectionFilters;
		}
	}
}