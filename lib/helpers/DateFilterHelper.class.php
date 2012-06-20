<?php
/**
 * @package modules.filter.lib.helpers
 */
class filter_DateFilterHelper
{
	/**
	 * @param string $unit from list modules_filter/dateunits
	 * @param integer $count
	 * @return string
	 */
	public static function getReferenceDate($unit, $count)
	{
		$calendar = date_Calendar::getInstance();
		switch ($unit)
		{
			case 'year' :
				$calendar->sub(date_Calendar::YEAR, $count);
				break;
				
			case 'month' :
				$calendar->sub(date_Calendar::MONTH, $count);
				break;
				
			case 'week' :
				$calendar->sub(date_Calendar::DAY, $count*7);
				break;
				
			case 'day' :
				$calendar->sub(date_Calendar::DAY, $count);
				break;
				
			case 'hour' :
				$calendar->sub(date_Calendar::HOUR, $count);
				break;
				
			case 'minute' :
				$calendar->sub(date_Calendar::MINUTE, $count);
				break;
		}
		return $calendar->toString();
	}
	
	/**
	 * @param string $period from list modules_filter/dateperiods
	 * @return string[] array($dateMin, $dateMax)
	 */
	public static function getDatesForPeriod($period)
	{
		switch ($period)
		{
			case 'today' :
				$calendar = date_Calendar::getInstance();
				$dateMin = self::getStartDate($calendar);
				$dateMax = self::getEndDate($calendar);
				break;
				
			case 'tomorrow' :
				$calendar = date_Calendar::getInstance()->add(date_Calendar::DAY, 1);
				$dateMin = self::getStartDate($calendar);
				$dateMax = self::getEndDate($calendar);
				break;
				
			case 'yesterday' :
				$calendar = date_Calendar::getInstance()->sub(date_Calendar::DAY, 1);
				$dateMin = self::getStartDate($calendar);
				$dateMax = self::getEndDate($calendar);
				break;
				
			case 'thisweek' :
				$calendar = date_Calendar::getInstance();
				$dayOfWeek = $calendar->getDayOfWeek();
				$dateMin = self::getStartDate($calendar->sub(date_Calendar::DAY, $dayOfWeek));
				$dateMax = self::getEndDate($calendar->add(date_Calendar::DAY, 6-$dayOfWeek));
				break;
				
			case 'thismonth' :
				$calendar = date_Calendar::getInstance();
				$dateMin = self::getStartDate($calendar->setDay(1));
				$dateMax = self::getEndDate($calendar->setDay($calendar->getDaysInMonth()));
				break;
				
			case 'thisyear' :
				$calendar = date_Calendar::getInstance();
				$dateMin = self::getStartDate($calendar->setMonth(1)->setDay(1));
				$dateMax = self::getEndDate($calendar->setMonth(12)->setDay(31));
				break;
		}
		return array($dateMin, $dateMax);
	}
	
	/**
	 * @param date_Calendar $calendar
	 * @return string
	 */
	private static function getStartDate($calendar)
	{
		return $calendar->setHour(0)->setMinute(0)->setSecond(0)->toString();
	}
	
	/**
	 * @param date_Calendar $calendar
	 * @return string
	 */
	private static function getEndDate($calendar)
	{
		return $calendar->setHour(23)->setMinute(59)->setSecond(59)->toString();
	}
}