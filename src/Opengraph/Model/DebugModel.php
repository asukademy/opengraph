<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Model;

use PHPHtmlParser\Dom;
use Windwalker\Core\Model\DatabaseModel;

/**
 * The DebugModel class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DebugModel extends DatabaseModel
{
	public function getItem()
	{

	}

	/**
	 * getHtml
	 *
	 * @return  string
	 */
	public function getHtml()
	{
		return file_get_contents(WINDWALKER_TEMP . '/test.html');
	}

	/**
	 * getDom
	 *
	 * @return  Dom
	 */
	public function getDom()
	{
		$dom = new Dom;

		$dom->load($this->getHtml());

		return $dom;
	}
}
