<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Analysis;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphObject;
use Facebook\HttpClients\FacebookGuzzleHttpClient;
use Opengraph\Facebook\FacebookJoomlaHttpClient;

/**
 * The FacebookAnalysis class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class FacebookAnalysis
{
	/**
	 * Property url.
	 *
	 * @var  string
	 */
	protected $url;

	/**
	 * Property id.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Property secret.
	 *
	 * @var  string
	 */
	protected $secret;

	/**
	 * Property session.
	 *
	 * @var  FacebookSession
	 */
	protected $session;

	/**
	 * Property graphObject.
	 *
	 * @var  GraphObject
	 */
	protected $graphObject;

	/**
	 * Class init.
	 *
	 * @param $id
	 * @param $secret
	 */
	public function __construct($id = null, $secret = null)
	{
		$this->id = $id;
		$this->secret = $secret;
	}

	/**
	 * init
	 *
	 * @return  static
	 */
	public function init()
	{
		FacebookSession::setDefaultApplication($this->id, $this->secret);
		FacebookRequest::setHttpClientHandler(new FacebookJoomlaHttpClient);

		$this->session = new FacebookSession('1114955295184483|goafukZ6p1pmlLugmhY3CFC_pCc');

		return $this;
	}

	/**
	 * parse
	 *
	 * @param string $url
	 *
	 * @return  static
	 *
	 * @throws \Facebook\FacebookRequestException
	 */
	public function parse($url)
	{
		$request = new FacebookRequest($this->session, 'GET', '/?id=' . urlencode($url), []);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();

		$this->graphObject = $graphObject;

		return $this;
	}

	/**
	 * get
	 *
	 * @param string $url
	 * @param bool   $refresh
	 *
	 * @return  $this
	 *
	 * @throws \Facebook\FacebookRequestException
	 */
	public function get($url)
	{
		if (!is_numeric($url))
		{
			$this->parse($url);

			$object = $this->getGraphObject();
			$id = $object->getProperty('og_object')->getProperty('id');
		}
		else
		{
			$id = $url;
		}

		$request = new FacebookRequest($this->session, 'POST', '/' . $id);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();

		$this->graphObject = $graphObject;

		return $this;
	}

	/**
	 * Method to get property GraphObject
	 *
	 * @return  GraphObject
	 */
	public function getGraphObject()
	{
		return $this->graphObject;
	}
}
