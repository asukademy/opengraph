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
use Joomla\Http\HttpFactory;
use Opengraph\Facebook\FacebookJoomlaHttpClient;
use Windwalker\Ioc;

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
		if ($this->session)
		{
			return $this;
		}

		FacebookSession::setDefaultApplication($this->id, $this->secret);
		FacebookRequest::setHttpClientHandler(new FacebookJoomlaHttpClient);

//		$http = HttpFactory::getHttp();
//		$response = $http->get('https://graph.facebook.com/v2.3/oauth/access_token?client_id=' . $this->id . '&client_secret=' . $this->secret . '&grant_type=client_credentials');
//
//		$result = json_decode($response->body);

		$this->session = new FacebookSession(Ioc::getConfig()->get('facebook.token'));

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
		$this->init();

		$query = [
			'id' => $url,
			'access_token' => $this->session->getAccessToken()
		];

		$request = new FacebookRequest($this->session, 'GET', '/?' . http_build_query($query), []);

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

		$request = new FacebookRequest($this->session, 'POST', '/' . $id . '?access_token=' . $this->session->getAccessToken());

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
