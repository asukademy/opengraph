<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Controller\Debug;

use Opengraph\Analysis\Analysis;
use Opengraph\Model\DebugModel;
use Windwalker\Core\Controller\Controller;
use Windwalker\Validator\Rule\UrlValidator;

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
		$url = $this->input->getUrl('q');

		$url = trim($url);

		$view = $this->getView();

		/** @var DebugModel $model */
		$model = $this->getModel();

		if ($url)
		{
			$urlValidator = new UrlValidator;

			if (!$urlValidator->validate($url))
			{
				return $this->backToHome('不是正確的網址格式');
			}
		}

		$view['q'] = $url ? : null;

		$view['item'] = $model->get($url);

		return $view->render();
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
