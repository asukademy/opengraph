<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Controller\Debug;

use Opengraph\Analysis\Analysis;
use Windwalker\Core\Controller\Controller;
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

		$url = trim($url);

		if (!$url)
		{
			return $this->backToHome('沒有網址');
		}

		$urlValidator = new UrlValidator;

		if (!$urlValidator->validate($url))
		{
			return $this->backToHome('不是正確的網址格式');
		}

		$analysis = new Analysis;
		$analysis->parse($url);

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
		return $this->setRedirect($this->package->router->buildHttp('debug'), $msg);
	}
}
