<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Controller\Sitemap;

use Asika\Sitemap\ChangeFreq;
use Asika\Sitemap\Sitemap;
use Opengraph\Table\Table;
use Windwalker\Core\Controller\Controller;
use Windwalker\Core\Router\RestfulRouter;
use Windwalker\DataMapper\DataMapper;

/**
 * The GetController class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class GetController extends Controller
{
	/**
	 * doExecute
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$mapper = new DataMapper(Table::RESULTS);

		$items = $mapper->findAll(null, 0, 1000);

		$sitemap = new Sitemap;

		$sitemap->addItem($this->package->router->buildHtml('debug', [], RestfulRouter::TYPE_FULL), 1.0, ChangeFreq::MONTHLY);

		foreach ($items as $item)
		{
			$loc = $this->package->router->buildHtml('debug', ['q' => $item->url], RestfulRouter::TYPE_FULL);

			$sitemap->addItem($loc, 0.8, ChangeFreq::WEEKLY, $item->last_search);
		}

		$this->app->response->setMimeType('text/xml');

		return $sitemap;
	}
}
