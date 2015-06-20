<?php
/**
 * Part of starter project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker;

use Opengraph\Analysis\FacebookAnalysis;

/**
 * The Ioc class.
 * 
 * @since  {DEPLOY_VERSION}
 */
abstract class Ioc extends \Windwalker\Core\Ioc
{
	/**
	 * getFBAnalysis
	 *
	 * @return  FacebookAnalysis
	 */
	public static function getFBAnalysis()
	{
		return static::get('fb.analysis');
	}
}
