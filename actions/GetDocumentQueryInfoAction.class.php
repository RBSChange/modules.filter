<?php
/**
 * generic_GetDocumentFilterInfoAction
 * @package modules.filter.actions
 */
class filter_GetDocumentQueryInfoAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$infoAsJson = $request->getParameter('infoAsJson');
		$filters = array();
		if ($infoAsJson)
		{
			$dfs = f_persistentdocument_DocumentFilterService::getInstance();
			$filters = $dfs->getFilterArrayFromJson($infoAsJson);
		}
		
		$result = array();
		foreach ($filters as $filter)
		{
			$filterInfo = array();
			$filterInfo['class'] = get_class($filter);
			$filterInfo['label'] = $filter->getLabel();
			$filterInfo['text'] = $filter->getText();
			$filterInfo['textWithMarkers'] = $filter->getText(true);
			$result[] = $filterInfo;
		}
		return $this->sendJSON($result);
	}
}