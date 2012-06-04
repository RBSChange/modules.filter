<?php
/**
 * commands_filter_AddFilter
 * @package modules.filter.command
 */
class commands_filter_AddFilter extends c_ChangescriptCommand
{
	/**
	 * @return String
	 * @example "<moduleName> <name>"
	 */
	function getUsage()
	{
		return "<moduleName> <name> <modelName> [<commaSeparatedParamNames>]";
	}

	/**
	 * @return String
	 * @example "initialize a document"
	 */
	function getDescription()
	{
		return "adds a new filter";
	}
	
	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 */
	protected function validateArgs($params, $options)
	{
		return count($params) == 3 || count($params) == 4;
	}

	/**
	 * @return String[]
	 */
//	function getOptions()
//	{
//	}

	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	function _execute($params, $options)
	{
		$this->message("== AddFilter ==");

		$this->loadFramework();
		
		$moduleName = strtolower($params[0]);
		$filterName = ucfirst($params[1]);
		$modelName = $params[2];
		$paramNames = isset($params[3]) ? explode(',', $params[3]) : array();
		if (!ModuleService::getInstance()->moduleExists($moduleName))
		{
			return $this->quitError("Component $moduleName does not exits");
		}
		else
		{
			$filterFolder = f_util_FileUtils::buildWebeditPath('modules', $moduleName, 'persistentdocument', 'filters');
			$filterFile = $filterFolder . DIRECTORY_SEPARATOR . $filterName . 'Filter.php';
			$class = $moduleName . '_' . $filterName . 'Filter';
		}
		
		if (file_exists($filterFile))
		{
			return $this->quitError('Filter "' . $filterName . '" already exists in ' . $moduleName . '".');
		}
		
		$generator = new builder_Generator();
		$generator->setTemplateDir(f_util_FileUtils::buildWebeditPath('modules', 'filter', 'templates', 'builder'));
		$generator->assign_by_ref('author', $this->getAuthor());
		$generator->assign_by_ref('name', $filterName);
		$generator->assign_by_ref('module', $moduleName);
		$generator->assign_by_ref('date', date('r'));
		$generator->assign_by_ref('class', $class);
		$generator->assign_by_ref('modelName', $modelName);
		$generator->assign_by_ref('parameters', $paramNames);
		$result = $generator->fetch('filter.tpl');
		
		f_util_FileUtils::mkdir($filterFolder);
		f_util_FileUtils::write($filterFile, $result);

		AutoloadBuilder::getInstance()->appendFile($filterFile);
		$this->message('Filter class path: ' . $filterFile);
		
		// Add locale.
		$filterKey = strtolower($filterName) . 'filter-';
		$baseKey = strtolower('m.' . $moduleName . '.bo.documentfilters');
		$keysInfos = array('fr_FR' => array($filterKey . 'label' => $filterName));
		LocaleService::getInstance()->updatePackage($baseKey, $keysInfos, false, true, '');
		
		$replacementParams = array();
		foreach ($paramNames as $paramName)
		{
			$replacementParams[] = '{'. $paramName . '}';
		}		
		$keysInfos = array('fr_FR' => array($filterKey . 'text' => $filterName . ": " . implode(', ', $replacementParams)));
		LocaleService::getInstance()->updatePackage($baseKey, $keysInfos, false, true, '');
		$this->message('Filter locales in ' . $baseKey . ': ' . $filterKey . 'label' . ' and ' . $filterKey  . 'text');
					
		return $this->quitOk("Command successfully executed");
	}
}