<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Helper;

/**
 * The ResultHelper class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class ResultHelper
{
	/**
	 * getScoreLabel
	 *
	 * @param string $score
	 *
	 * @return  string
	 */
	public static function getScoreLabel($score)
	{
		if ($score >= 90)
		{
			return 'label-success';
		}
		elseif ($score < 95 && $score >= 60)
		{
			return 'label-warning';
		}
		else
		{
			return 'label-danger';
		}
	}
}
