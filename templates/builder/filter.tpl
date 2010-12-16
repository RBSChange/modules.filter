<?php
/**
 * <{$class}>
 * @package modules.<{$module}>.persistentdocument.filters
 */
class <{$class}> extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
<{foreach from=$parameters item=paramterName name=params}>
<{if $smarty.foreach.params.index != 0}>

<{/if}>
		// Parameter "<{$paramterName}>".
		$parameter = ...
		$this->setParameter('<{$paramterName}>', $parameter);
<{/foreach}>
	}
	
	/**
	 * @return String
	 */
	public static function getDocumentModelName()
	{
		return '<{$modelName}>';
	}
	
	/**
	 * Check a single given object. 
	 * @param unknown $value
	 * @return boolean
	 */
//	public function checkValue($value)
//	{
//	}

	/**
	 * Get the query to find documents matching this filter.
	 * @return f_persistentdocument_criteria_Query
	 */
//	public function getQuery()
//	{
//	}
}