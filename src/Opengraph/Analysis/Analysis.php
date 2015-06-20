<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Analysis;

use Joomla\Http\HttpFactory;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use Windwalker\Data\Data;
use Windwalker\Dom\HtmlElement;
use Windwalker\Dom\HtmlElements;
use Windwalker\Filesystem\File;
use Windwalker\Utilities\ArrayHelper;

/**
 * The Analysis class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Analysis
{
	/**
	 * Property dom.
	 *
	 * @var  Dom
	 */
	protected $dom;

	/**
	 * Property metas.
	 *
	 * @var array
	 */
	protected $metas;

	/**
	 * Property opengraphs.
	 *
	 * @var array
	 */
	protected $opengraphs = [];

	/**
	 * Property images.
	 *
	 * @var  HtmlNode[]
	 */
	protected $images;

	public function __construct()
	{
		$this->dom = new Dom;
	}

	/**
	 * parse
	 *
	 * @param string $url
	 *
	 * @return  $this
	 */
	public function parse($url)
	{
		// Cache
		$file = new \SplFileInfo(WINDWALKER_CACHE . '/html/' . md5($url) . '.html');

		if (is_file($file->getPathname()))
		{
			$html = file_get_contents($file->getPathname());
		}
		else
		{
			$html = $this->download($url, $file)->body;

			File::write($file->getPathname(), $html);
		}

		$this->dom->load($html);

		return $this;
	}

	/**
	 * download
	 *
	 * @param string       $url
	 * @param \SplFileInfo $file
	 *
	 * @return  \Joomla\Http\Response
	 */
	protected function download($url, \SplFileInfo $file)
	{
		$http = HttpFactory::getHttp([], 'curl');

		return $http->get($url);
	}

	/**
	 * parseMetas
	 *
	 * @return  void
	 */
	protected function parseMetas()
	{
		if ($this->metas)
		{
			return;
		}

		$metas = $this->dom->find('head meta');

		$metadata['general'] = [];
		$metadata['facebook'] = [];
		$metadata['twitter'] = [];

		// General
		foreach ($metas as $meta)
		{
			if ($meta->name)
			{
				$metadata['general'][] = $meta;
			}

			if (strpos($meta->property, 'og:') !== false || strpos($meta->property, 'admin:') !== false)
			{
				$metadata['facebook'][] = $meta;
				$this->opengraphs[$meta->property] = $meta;
			}

			if (strpos($meta->property, 'twitter:') !== false)
			{
				$metadata['twitter'][] = $meta;
			}
		}

		$this->metas = $metadata;
	}

	protected function parseImages()
	{
		$this->images = $this->images ? : $this->dom->find('img');
	}

	/**
	 * Method to get property Metas
	 *
	 * @param string $type
	 *
	 * @return HtmlNode[]|array
	 */
	public function getMetas($type = null)
	{
		$this->parseMetas();

		if ($type)
		{
			return $this->metas[$type];
		}
		else
		{
			return $this->metas;
		}
	}

	/**
	 * Method to get property Images
	 *
	 * @return  HtmlNode[]
	 */
	public function getImages()
	{
		$this->parseImages();

		return $this->images;
	}

	/**
	 * getOpengraph
	 *
	 * @param string $name
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function getOpengraph($name, $default = null)
	{
		$this->parseMetas();

		return ArrayHelper::getValue($this->opengraphs, $name, $default ? : new Data);
	}
}
