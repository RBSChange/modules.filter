<?php
/**
 * generic_GetPropertyInfoForFilterAction
 * @package modules.filter.actions
 */
class filter_GetPropertyInfoForFilterAction extends f_action_BaseJSONAction
{
	/**
	 * @param Context $context
	 * @param Request $request
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
		$result['propertyInfo'] = array();

		if ($propertyName === null && $parameter instanceof f_persistentdocument_DocumentFilterRestrictionParameter)
		{
			$propertyName = $parameter->getPropertyName();
		}		
		$propertyInfo = $parameter->getPropertyInfoByName($propertyName);
		if ($propertyInfo !== null)
		{
			$result['propertyInfo']['type'] = $propertyInfo->getType();
			if ($propertyInfo->getType() === BeanPropertyType::DOCUMENT)
			{
				$pn = $propertyName === null ? $parameterName: $propertyName;
				$dialog = $parameter->getCustomPropertyAttribute($parameterName, 'dialog');
				if ($dialog) {$result['propertyInfo']['dialog'] = $dialog;}
				
				$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName($propertyInfo->getDocumentType());
				$moduleselector = $parameter->getCustomPropertyAttribute($parameterName, 'moduleselector');
				$result['propertyInfo']['moduleselector'] = ($moduleselector) ? $moduleselector : $model->getModuleName();
				$allow = $parameter->getCustomPropertyAttribute($parameterName, 'allow');
				if ($allow)
				{
					$result['propertyInfo']['allow'] = $allow;
				}
				else
				{
					$docTypes = array($propertyInfo->getDocumentType());
					$chidrenNames = $model->getChildrenNames();
					if (is_array($chidrenNames))
					{
						$docTypes = array_merge($docTypes, $chidrenNames);
					}
					$result['propertyInfo']['allow'] = str_replace('/', '_', implode(',', $docTypes));
				}
			}
			
			$result['propertyInfo']['hasList'] = false;
			if ($propertyInfo->hasList())
			{
				$result['propertyInfo']['hasList'] = true;
				$result['propertyInfo']['listId'] = $propertyInfo->getList()->getListId();
			}
			$result['propertyInfo']['validationRules'] = $propertyInfo->getValidationRules();
			$result['propertyInfo']['hasDefaultValue'] = false;
			if ($propertyInfo->getDefaultValue() !== null)
			{
				$result['propertyInfo']['hasDefaultValue'] = true;
				$result['propertyInfo']['defaultValue'] = $propertyInfo->getDefaultValue();
			}
		}
		
		return $this->sendJSON($result);
	}
}