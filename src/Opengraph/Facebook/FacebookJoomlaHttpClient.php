<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Facebook;

use Facebook\FacebookSDKException;
use Facebook\HttpClients\FacebookHttpable;
use Joomla\Http\Http;
use Joomla\Http\HttpFactory;
use Joomla\Uri\Uri;

/**
 * The FacebookJoomlaHttpClient class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class FacebookJoomlaHttpClient implements FacebookHttpable
{
	/**
	 * @var array The headers to be sent with the request
	 */
	protected $requestHeaders = array();

	/**
	 * @var array The headers received from the response
	 */
	protected $responseHeaders = array();

	/**
	 * @var int The HTTP status code returned from the server
	 */
	protected $responseHttpStatusCode = 0;

	/**
	 * Property http.
	 *
	 * @var  Http
	 */
	protected static $http;

	/**
	 * @param Http  $http Joomla http
	 */
	public function __construct(Http $http = null)
	{
		static::$http = $http ?: HttpFactory::getHttp([], 'curl');
	}

	/**
	 * The headers we want to send with the request
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addRequestHeader($key, $value)
	{
		$this->requestHeaders[$key] = $value;
	}

	/**
	 * The headers returned in the response
	 *
	 * @return array
	 */
	public function getResponseHeaders()
	{
		return $this->responseHeaders;
	}

	/**
	 * The HTTP status response code
	 *
	 * @return int
	 */
	public function getResponseHttpStatusCode()
	{
		return $this->responseHttpStatusCode;
	}

	/**
	 * Sends a request to the server
	 *
	 * @param string $url        The endpoint to send the request to
	 * @param string $method     The request method
	 * @param array  $parameters The key value pairs to be sent in the body
	 *
	 * @return string Raw response from the server
	 *
	 * @throws \Facebook\FacebookSDKException
	 */
	public function send($url, $method = 'GET', $parameters = array())
	{
		try
		{
			if ($method == 'GET')
			{
				$uri = new Uri($url);

				foreach ($parameters as $key => $param)
				{
					$uri->setVar($key, $param);
				}

				$rawResponse = static::$http->get($uri->toString());
			}
			else
			{
				$rawResponse = static::$http->$method($url, $method, $parameters);
			}
		}
		catch (\RuntimeException $e)
		{
			throw new FacebookSDKException($e->getMessage(), $e->getCode());
		}

		$this->responseHttpStatusCode = $rawResponse->code;
		$this->responseHeaders = $rawResponse->headers;

		return $rawResponse->body;
	}
}
