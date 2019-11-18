<?php

namespace BaseTemplatePHP\Middleware;

use BaseTemplatePHP\Providers\Middleware\IMiddlewareLayer;
use BaseTemplatePHP\Providers\Exception\PageException;
use Pimple\Container;
use Closure;

class ExampleMiddleware implements IMiddlewareLayer
{
	private $csrf;
	private $page;
	private $environment;

	public function __construct(Container $container)
	{
		$this->csrf = $container['CsrfService'];
		$this->page = $container['page'];
		$this->environment = $container['settings'];
	}

	public function handle($request, Closure $next, $response)
	{
		if ($this->csrf->verfiyToken($request->_token)) {
			return $next($request, $response);
		} else {
			throw new PageException("Csrf fuck forbidden: ", 403, null,  $this->csrf->getTokenSession());
		}
	}
}
