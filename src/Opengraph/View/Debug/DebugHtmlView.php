<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\View\Debug;

use Opengraph\Analysis\Analysis;
use Opengraph\Helper\DateHelper;
use Opengraph\Helper\ResultHelper;
use Windwalker\Core\View\BladeHtmlView;
use Windwalker\Data\Data;
use Windwalker\Dom\HtmlElement;
use Windwalker\Uri\Uri;
use Windwalker\Utilities\ArrayHelper;

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
		if ($data->item->notNull())
		{
			$data->item->graph_object = json_decode($data->item->graph_object);
			$data->preview_uri = new Uri($data->q);

			$analysis = new Analysis;
			$analysis->parse($data->item->html);

			$data->analysis = $analysis;

			$this->prepareOpengraph($data, $analysis);

			$this->prepareFacebook($data, $data->item->graph_object);

			$this->prepareRecommend($data, $analysis);
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
		$scorePerItem = 20;

		$og->title = new Data(['content' => $analysis->getOpengraph('og:title')->content, 'score' => $scorePerItem]);

		if (!$og->title->content)
		{
			$og->title->content = $analysis->getTitle();
			$og->title->score = 10;
			$og->title->warning = true;
		}

		$og->site_name = new Data(['content' => $analysis->getOpengraph('og:site_name')->content, 'score' => $scorePerItem]);

		if (!$og->site_name->content)
		{
			$og->site_name->score = 0;
		}

		$og->url = new Data(['content' => $analysis->getOpengraph('og:url')->content, 'score' => $scorePerItem]);

		if (!$og->url->content)
		{
			$og->url->content = $data->q;
			$og->url->score = 10;
			$og->url->warning = true;
		}

		$og->description = new Data(['content' => $analysis->getOpengraph('og:description')->content, 'score' => $scorePerItem]);

		if (!$og->description->content)
		{
			$og->description->content = $analysis->findMeta('general', 'description')->content;
			$og->description->score = 10;
			$og->description->warning = true;
		}

		$og->images = new Data(['score' => $scorePerItem]);
		$images = [];
		$imgs = $analysis->getOpengraph('og:image');

		if (!count($imgs))
		{
			$imgs = $analysis->getImages();
			$og->images->score = 10;
			$og->images->warning = true;

			foreach ($imgs as $image)
			{
				$images[] = $image->src;
			}
		}
		else
		{
			foreach ($imgs as $image)
			{
				$images[] = $image->content;
			}
		}


		$og->images->content = $images;

		$data->og = $og;

		$data->score = ArrayHelper::getColumn((array) $og, 'score', []);
		$data->score = array_sum($data->score);
		$data->score_label = ResultHelper::getScoreLabel($data->score);
	}

	/**
	 * prepareFacebook
	 *
	 * @param Data  $data
	 * @param mixed $object
	 *
	 * @return  void
	 */
	protected function prepareFacebook(Data $data, $object)
	{
		$fb = new Data;

		foreach ((array) $object as $key => $value)
		{
			$fb->$key = $value;
		}

		foreach ((array) $fb->image as $k => $image)
		{
			$fb->image[$k] = new Data($image);
		}

		$fb->created_time = DateHelper::format($fb->created_time);
		$fb->updated_time = DateHelper::format($fb->updated_time);

		$data->fb = $fb;
	}

	/**
	 * prepareRecommend
	 *
	 * @param Data     $data
	 * @param Analysis $analysis
	 *
	 * @return  void
	 */
	protected function prepareRecommend(Data $data, Analysis $analysis)
	{
		$recommend = [];

		if (!$analysis->getOpengraph('og:title')->content && $analysis->getTitle())
		{
			$recommend[] = new HtmlElement('meta', null, [
				'property' => 'og:title',
				'content' => $analysis->getTitle()
			]);
		}

		if (!$analysis->getOpengraph('og:site_name')->content)
		{
			$title = $analysis->getTitle();

			preg_match('/.*[\||-](.*)/', $title, $matches);

			if ($matches)
			{
				$title = trim($matches[0]);

				$recommend[] = new HtmlElement('meta', null, [
					'property' => 'og:site_name',
					'content' => $title
				]);
			}
		}

		if (!$analysis->getOpengraph('og:url')->content)
		{
			$recommend[] = new HtmlElement('meta', null, [
				'property' => 'og:url',
				'content' => $data->q
			]);
		}

		if (!$analysis->getOpengraph('og:description')->content && $analysis->findMeta('general', 'description')->content)
		{
			$recommend[] = new HtmlElement('meta', null, [
				'property' => 'og:description',
				'content' => $analysis->findMeta('general', 'description')->content
			]);
		}

		if (!count($analysis->getOpengraph('og:image')))
		{
			$dom = $analysis->getDom();

			$imgs = $dom->find('article img, .content img, .article-content img, main-content img, .page-item img');

			if ($imgs)
			{
				$imgs = $analysis->addImageBase($imgs);
			}
			else
			{
				$imgs = $analysis->getImages();
			}

			if ($imgs)
			{
				$recommend[] = new HtmlElement('meta', null, [
					'property' => 'og:image',
					'content' => $imgs[0]->src
				]);
			}
		}

		$recommend = implode("\n", $recommend);

		if (!trim($recommend))
		{
			$recommend = '恭喜您，您不需增加任何的 Opengraph 標籤';
		}

		$data->recommend = $recommend;
	}
}
