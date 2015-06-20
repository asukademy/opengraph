<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Controller\Debug;

use Joomla\Http\HttpFactory;
use Opengraph\Analysis\Analysis;
use Opengraph\Analysis\FacebookAnalysis;
use Opengraph\Model\DebugModel;
use Windwalker\Core\Controller\Controller;
use Windwalker\Data\Data;
use Windwalker\Uri\Uri;
use Windwalker\Validator\Rule\UrlValidator;

/**
 * The SaveController class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class SaveController extends Controller
{
	/**
	 * doExecute
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$url = $this->input->post->getUrl('q');
		$refreshFB = $this->input->post->get('refresh_fb', 0);

		$url = trim($url);
		$url = trim($url, '/');

		if (!$url)
		{
			return $this->backToHome('沒有網址');
		}

		$urlValidator = new UrlValidator;

		if (!$urlValidator->validate($url))
		{
			return $this->backToHome('不是正確的網址格式');
		}

		/** @var DebugModel $model */
		$model = $this->getModel();

		try
		{
			$model['fb.refresh'] = $refreshFB;

			$model->save($url);
		}
		catch (\Exception $e)
		{
			if (WINDWALKER_DEBUG)
			{
				throw $e;
			}

			return $this->backToHome($e->getMessage());
		}


		$this->setRedirect($this->package->router->buildHtml('debug', ['q' => $url]));

		return true;
	}

	/**
	 * backToHome
	 *
	 * @param string $msg
	 *
	 * @return  static
	 */
	protected function backToHome($msg)
	{
		return $this->setRedirect($this->package->router->buildHttp('debug', ['q' => $this->input->getUrl('q')]), $msg);
	}
}
