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
use Windwalker\Uri\Uri;
use Windwalker\Utilities\ArrayHelper;

/**
 * The Analysis class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Analysis
{
	/**
	 * Property url.
	 *
	 * @var  string
	 */
	protected $url;

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

	/**
	 * Property title.
	 *
	 * @var  string
	 */
	protected $title;

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
		$this->url = $url;

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

				if ($meta->property == 'og:image')
				{
					$this->opengraphs[$meta->property][] = $meta;
				}
				else
				{
					$this->opengraphs[$meta->property] = $meta;
				}
			}

			if (strpos($meta->property, 'twitter:') !== false)
			{
				$metadata['twitter'][] = $meta;
			}
		}

		$this->metas = $metadata;
	}

	/**
	 * parseImages
	 *
	 * @return  Dom\HtmlNode[]
	 */
	protected function parseImages()
	{
		if ($this->images)
		{
			return;
		}

		$images = $this->dom->find('img');

		$this->images = $this->addImageBase($images);
	}

	/**
	 * addImageBase
	 *
	 * @param HtmlNode[] $images
	 *
	 * @return  HtmlNode[]
	 */
	public function addImageBase($images)
	{
		$uri = new Uri($this->url);
		$i = 1;

		$tmp = [];

		foreach ($images as $image)
		{
			if ($i >= 10)
			{
				break;
			}

			$src = $image->src;

			if ($src)
			{
				if ($src[0] == '/')
				{
					$src = $uri->toString(['scheme', 'user', 'pass', 'host', 'port']) . $src;
				}
				elseif (strpos($src, 'http') !== 0)
				{
					$base = dirname($uri->toString());

					$src = $base . '/' . $src;
				}
			}

			$tmp[] = new Data(['src' => $src]);

			$i++;
		}

		return $tmp;
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
	 * findMetaContent
	 *
	 * @param string $type
	 * @param string $name
	 *
	 * @return  HtmlNode|Data
	 */
	public function findMeta($type, $name)
	{
		if (!isset($this->metas[$type]))
		{
			return null;
		}

		foreach ($this->metas[$type] as $meta)
		{
			if ($meta->property == $name || $meta->name == $name)
			{
				return $meta;
			}
		}

		return new Data;
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
	 * getTitle
	 *
	 * @return  string
	 */
	public function getTitle()
	{
		if ($this->title)
		{
			return $this->title;
		}

		/** @var HtmlNode[] $title */
		$title = $this->dom->find('head title');

		if (!count($title))
		{
			return null;
		}

		return $this->title = $title[0]->text;
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

	/**
	 * Method to get property Dom
	 *
	 * @return  Dom
	 */
	public function getDom()
	{
		return $this->dom;
	}
}
