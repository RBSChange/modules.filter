<?php
/**
 * generic_GetAvailableRestrictionsForFilterAction
 * @package modules.filter.actions
 */
class filter_GetAvailableRestrictionsForFilterAction extends change_JSONAction
{
	/**
	 * @param change_Context $context
	 * @param change_Request $request
	 */
	public function _execute($context, $request)
	{
		
		$filterClass = $request->getParameter('filter');
		$parameterName = $request->getParameter('parameterName');
		$propertyName = $request->getParameter('propertyName');
		
		$filter = f_util_ClassUtils::newInstance($filterClass);
		$parameter = $filter->getParameter($parameterName);
			
		$result = array();
		$result['filter'] = $filterClass;
		$result['parameterName'] = $parameterName;
		$result['propertyName'] = $propertyName;
		$result['availableRestrictions'] = array();
		if ($parameter instanceof f_persistentdocument_DocumentFilterRestrictionParameter)
		{
			if ($propertyName === null)
			{
				$propertyName = $parameter->getPropertyName();
			}
			$restrictions = $parameter->getAllowedRestrictions($propertyName);
			
			$dfs = f_persistentdocument_DocumentFilterService::getInstance();
			foreach ($restrictions as $restriction)
			{
				$result['availableRestrictions'][$restriction] = $dfs->getRestrictionAsText($restriction);
			}
		}
		
		return $this->sendJSON($result);
	}
}