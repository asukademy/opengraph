<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Model;

use Joomla\Http\HttpFactory;
use Opengraph\Analysis\FacebookAnalysis;
use Opengraph\Helper\DateHelper;
use Opengraph\Table\Table;
use PHPHtmlParser\Dom;
use Windwalker\Core\Model\DatabaseModel;
use Windwalker\Data\Data;
use Windwalker\DataMapper\DataMapper;
use Windwalker\Ioc;

/**
 * The DebugModel class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DebugModel extends DatabaseModel
{
	/**
	 * save
	 *
	 * @param $url
	 *
	 * @return bool
	 */
	public function save($url)
	{
		$data = $this->get($url);

		if ($data->url && $data->graph_id && !$this['fb.refresh'])
		{
			return $data;
		}

		$http = HttpFactory::getHttp();

		$response = $http->get($url);

		if ($response->code != 200)
		{
			throw new \RuntimeException('網址無法存取');
		}

		if (!$data->graph_id || $this['fb.refresh'])
		{
			$fb = Ioc::getFBAnalysis();
			$fb->init()->get($url);

			$object = $fb->getGraphObject();

			$data->graph_id = $object->getProperty('id');
			$data->graph_object = json_encode($object->asArray());
		}

		$data->url = $url;
		$data->html = $response->body;
		$data->last_search = DateHelper::format('now');
		$data->searches += 1;

		// Create
		if (!$data->id)
		{
			$data->created = DateHelper::format('now');
		}
		// Update
		else
		{

		}

		$this->getDataMapper()->saveOne($data, 'id');

		return true;
	}

	/**
	 * get
	 *
	 * @param string $url
	 *
	 * @return  Data
	 */
	public function get($url)
	{
		$mapper = $this->getDataMapper();

		if (!$url)
		{
			return new Data;
		}

		return $mapper->findOne(['url' => $url]);
	}

	/**
	 * getDataMapper
	 *
	 * @return  DataMapper
	 */
	protected function getDataMapper()
	{
		return new DataMapper(Table::RESULTS);
	}
}
