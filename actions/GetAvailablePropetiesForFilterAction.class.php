<?php
/**
 * generic_GetAvailablePropetiesForFilterAction
 * @package modules.filter.actions
 */
class filter_GetAvailablePropetiesForFilterAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$filterClass = $request->getParameter('filter');
		$parameterName = $request->getParameter('parameterName');
		$filter = f_util_ClassUtils::newInstance($filterClass);
		$parameter = $filter->getParameter($parameterName);
		
		$result = array();
		$result['filter'] = $filterClass;
		$result['parameterName'] = $parameterName;
		$result['availableProperties'] = array();
		if ($parameter instanceof f_persistentdocument_DocumentFilterRestrictionParameter)
		{
			$propertyInfos = $parameter->getAllowedPropertyInfos();
			foreach ($propertyInfos as $name => $propertyInfo)
			{
				$result['availableProperties'][$name] = f_Locale::translateUI($propertyInfo->getLabelKey());
			}
		}
		
		return $this->sendJSON($result);
	}
}