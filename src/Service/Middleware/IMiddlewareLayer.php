<?php

namespace BaseTemplatePHP\Service\Middleware;

use Closure;

interface IMiddlewareLayer
{
	public function handle($request, Closure $next, $response);
}
