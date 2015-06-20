<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\View\Debug;

use Opengraph\Analysis\Analysis;
use Opengraph\Analysis\FacebookAnalysis;
use Opengraph\Helper\DateHelper;
use Opengraph\Helper\ResultHelper;
use Windwalker\Core\View\BladeHtmlView;
use Windwalker\Data\Data;
use Windwalker\Dom\HtmlElement;
use Windwalker\Dom\HtmlElements;
use Windwalker\Ioc;
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
		$data->item = new Data;

		$config = Ioc::getConfig();

		if ($data->q)
		{
			$analysis = new Analysis;
			$analysis->parse($data->q);

			$data->analysis = $analysis;

			$this->prepareOpengraph($data, $analysis);


			$fb = new FacebookAnalysis($config->get('facebook.id'), $config->get('facebook.secret'));
			$fb->init()->get($data->q);

			$this->prepareFacebook($data, $fb);

			$this->prepareRecommend($data, $analysis, $fb);
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
	 * @param Data             $data
	 * @param FacebookAnalysis $fbAnalysis
	 *
	 * @return  void
	 */
	protected function prepareFacebook(Data $data, FacebookAnalysis $fbAnalysis)
	{
		$fb = new Data;

		$object = $fbAnalysis->getGraphObject();

		foreach ($object->asArray() as $key => $value)
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

	protected function prepareRecommend(Data $data, Analysis $analysis, FacebookAnalysis $fbAnalysis)
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

		if (!count($analysis->getOpengraph('og:images')))
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

		$data->recommend = implode("\n", $recommend);
	}
}
