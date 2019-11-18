<?php

namespace BaseTemplatePHP\Providers\Exception;

class PageException extends \Exception
{
	private $componentPath;
	private $data;

	public function __construct(
		$message,
		$code = 500,
		Exception $previous = null,
		$data = null,
		$componentPath = 'errorShow.php'
	) {
		parent::__construct($message, @$code, $previous);
		$this->componentPath = $componentPath;
		$this->data = $data;
	}

	public function getComponentPath()
	{
		return $this->componentPath;
	}

	public function getData()
	{
		return $this->data;
	}
}
