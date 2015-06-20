<?php
/**
 * Part of og project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Opengraph\Facebook;

use Opengraph\Analysis\FacebookAnalysis;
use Windwalker\DI\Container;
use Windwalker\DI\ServiceProviderInterface;

/**
 * The FacebookProvider class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class FacebookProvider implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container $container The DI container.
	 *
	 * @return  void
	 */
	public function register(Container $container)
	{
		$closure = function(Container $container)
		{
			$config = $container->get('system.config');

			return new FacebookAnalysis($config->get('facebook.id'), $config->get('facebook.secret'));
		};

		$container->share('fb.analysis', $closure);
	}
}
