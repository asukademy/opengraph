<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Helper;

/**
 * The DateHelper class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DateHelper
{
	const FORMAT_SQL = 'Y-m-d H:i:s';

	/**
	 * format
	 *
	 * @param string $date
	 * @param string $format
	 *
	 * @return  string
	 */
	public static function format($date = 'now', $format = self::FORMAT_SQL)
	{
		$datetime = new \DateTime($date);

		$datetime->setTimezone(new \DateTimeZone('Asia/Taipei'));

		return $datetime->format($format);
	}
}
