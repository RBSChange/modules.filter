<?php
/**
 * generic_GetDocumentFilterInfoAction
 * @package modules.filter.actions
 */
class filter_GetDocumentFilterInfoAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$infoAsJson = $request->getParameter('infoAsJson');
		if ($infoAsJson)
		{
			$dfs = f_persistentdocument_DocumentFilterService::getInstance();
			$filter = $dfs->getFilterInstanceFromJson($infoAsJson);
		}
		else 
		{
			$filterClass = $request->getParameter('filter');
			$filter = f_util_ClassUtils::newInstance($filterClass);
		}
		
		$result = array();
		$result['class'] = $filterClass;
		$result['label'] = $filter->getLabel();
		$result['text'] = $filter->getText();
		$result['textWithMarkers'] = $filter->getText(true);
		
		return $this->sendJSON($result);
	}
}