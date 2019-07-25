<?php

namespace BaseTemplatePHP\Providers\Routers;

use Klein\klein;
use Klein\Request;
use Pimple\Container;

class RoutersDispatch
{
	private $klein;
	private $container;

	public function __construct(Container $container = null)
	{
		$this->container = $container ?? new Container();
		$this->klein = new Klein;
		$respondAPI = new RespondAPI;
		$respondPages = new RespondPages;

		$this->initSubDirectory(); // 若專案目錄是 "sub Directory" 則加入此函數設定$_SERVER['REQUEST_URI']
		$respondAPI->responds($this->container, $this->klein);
		$respondPages->responds($this->container, $this->klein);
		$kleinRequest = $this->initSubDirectory();
		$this->klein->dispatch($kleinRequest);

		// initSubDirectory function (2) content
		// $this->klein->dispatch();
	}

	private function initSubDirectory()
	{
		$kleinRequest = Request::createFromGlobals();
		$uri = $kleinRequest->server()->get('REQUEST_URI');
		$kleinRequest->server()->set('REQUEST_URI', substr($uri, strlen($this->container['settings']['app']['routerStart'])));
		return $kleinRequest;

		// https://github.com/klein/klein.php/wiki/Sub-Directory-Installation
		// $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($this->container['settings']['app']['routerStart']));
	}
}
