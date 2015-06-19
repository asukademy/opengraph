<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\View\Debug;

use Opengraph\Analysis\Analysis;
use Windwalker\Core\View\BladeHtmlView;
use Windwalker\Data\Data;

/**
 * The DebugHtmlView class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DebugHtmlView extends BladeHtmlView
{
	/**
	 * prepareData
	 *
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	protected function prepareData($data)
	{
		$data->item = new Data;

		if ($data->q)
		{
			$analysis = new Analysis;
			$analysis->parse($data->q);

			$data->analysis = $analysis;
		}
	}
}
