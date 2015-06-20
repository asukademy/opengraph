<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\View\Debug;

use Opengraph\Analysis\Analysis;
use Opengraph\Helper\ResultHelper;
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

			$this->prepareOpengraph($data, $analysis);
		}
	}

	/**
	 * prepareOpengraph
	 *
	 * @param Data     $data
	 * @param Analysis $analysis
	 *
	 * @return  void
	 */
	protected function prepareOpengraph(Data $data, Analysis $analysis)
	{
		$og = new Data;

		$og->title     = $analysis->getOpengraph('og:title')->content;
		$og->site_name = $analysis->getOpengraph('og:site_name')->content;
		$og->url       = $analysis->getOpengraph('og:url')->content;
		$og->image     = $analysis->getOpengraph('og:image')->content;
		// $og->type      = $analysis->getOpengraph('og:type')->content;
		$og->description = $analysis->getOpengraph('og:description')->content;

		$data->og = $og;

		$currentOG = array_filter($og->dump(), 'strlen');
		$data->score = 100 / count($og) * count($currentOG);
		$data->score_label = ResultHelper::getScoreLabel($data->score);
	}
}
