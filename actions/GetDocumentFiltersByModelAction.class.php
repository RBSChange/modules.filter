<?php
/**
 * generic_GetDocumentFiltersByModelAction
 * @package modules.filter.actions
 */
class filter_GetDocumentFiltersByModelAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		list($allow, $methods) = explode('::', $request->getParameter('allow'));
		$methodsArray = ($methods) ? explode(',', $methods) : array();
		$fieldtype = $request->getParameter('fieldtype');
		if ($fieldtype == 'objectfilter')
		{
			$keys = explode(',', $allow);
			list($moduleName, $documentName) = explode('/', $keys[0]);			
			$filters = f_persistentdocument_DocumentFilterService::getInstance()->getFiltersByKeys($keys, $methodsArray);
		}
		else
		{
			list($moduleName, $documentName) = explode('/', $allow);			
			$filters = f_persistentdocument_DocumentFilterService::getInstance()->getFiltersByModelName('modules_'.$allow, $methodsArray);
		}
		
		$result = array();
		$labels = array();
		foreach ($filters as $filter)
		{
			$label = f_util_ClassUtils::newInstance($filter)->getLabel();
			$result[] = array('class' => $filter, 'label' => $label);
			$labels[] = $label;
		}
		array_multisort($result, $labels);
		$subTitle = f_Locale::translateUI('&modules.'. $moduleName .'.bo.documentfilters.Query-on-'. $documentName.'Label;');
		$orSubTitle = f_Locale::translateUI('&modules.'. $moduleName .'.bo.documentfilters.Or-query-on-'. $documentName.'Label;');
		return $this->sendJSON(array('subTitle' => $subTitle, 'orSubTitle' => $orSubTitle, 'filters' => $result));
	}
}