<?php

namespace BaseTemplatePHP\Controllers;

use Pimple\Container;
use BaseTemplatePHP\Providers\Exception\PageException;

class ExampleCtrl
{
	private $page;
	private $environment;

	public function __construct(Container $container)
	{
		$this->page = $container['page'];
		$this->environment = $container['settings'];
	}

	public function index($request, $response)
	{
		$this->page->routerRoot = $this->environment['app']['routerStart'];
		$this->page->assetPath = $this->environment['renderer']['assetPath'];
		$this->page->componentsPath = $this->environment['renderer']['componentsPath'];
		$this->page->isLogined = $this->authService->isLogind();
		$this->page->layout($this->environment['renderer']['templatePath'] . "default.php");
		$this->page->render($this->environment['renderer']['contentsPath'] . "home/dashborad.php");
	}

	public function error($request, $response)
	{
		$this->page->routerRoot = $this->environment['app']['routerStart'];
		$this->page->assetPath = $this->environment['renderer']['assetPath'];
		$this->page->componentsPath = $this->environment['renderer']['componentsPath'];
		$this->page->layout($this->environment['renderer']['templatePath'] . "error.php");
		// $this->page->render($this->page->errorComponent);
		$this->page->render("");
	}

	public function welcome($request, $response)
	{
		$this->page->routerRoot = $this->environment['app']['routerStart'];
		$this->page->assetPath = $this->environment['renderer']['assetPath'];
		$this->page->componentsPath = $this->environment['renderer']['componentsPath'];
		$this->page->layout($this->environment['renderer']['contentsPath'] . "home/welcome.php");
		$this->page->render("");
	}
}
