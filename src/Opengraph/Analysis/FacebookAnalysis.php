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
use Opengraph\Facebook\FacebookJoomlaHttpClient;
use Windwalker\Ioc;

/**
 * The FacebookAnalysis class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class FacebookAnalysis
{
	const GET = 'GET';
	const POST = 'POST';

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
		if ($this->session)
		{
			return $this;
		}

		FacebookSession::setDefaultApplication($this->id, $this->secret);
		FacebookRequest::setHttpClientHandler(new FacebookJoomlaHttpClient);

		$this->session = new FacebookSession(Ioc::getConfig()->get('facebook.token'));

		return $this;
	}

	/**
	 * parse
	 *
	 * @param string $url
	 * @param string $method
	 *
	 * @return static
	 * @throws \Facebook\FacebookRequestException
	 */
	public function parse($url, $method = self::GET)
	{
		$this->init();

		$query = [
			'id' => $url,
			'access_token' => $this->session->getAccessToken()
		];

		$request = new FacebookRequest($this->session, $method, '/?' . http_build_query($query), []);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();

		$this->graphObject = $graphObject;

		return $this;
	}

	/**
	 * get
	 *
	 * @param string $url
	 * @param string $method
	 *
	 * @return static
	 * @throws \Facebook\FacebookRequestException
	 */
	public function get($url, $method = self::POST)
	{
		$this->init();

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

		$request = new FacebookRequest($this->session, $method, '/' . $id . '?access_token=' . $this->session->getAccessToken());

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
