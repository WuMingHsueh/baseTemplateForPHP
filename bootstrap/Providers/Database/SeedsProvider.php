<?php

namespace BaseTemplatePHP\Providers\Database;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Faker\Factory as FakerFactory;
use Pimple\Container;
use BaseTemplatePHP\Models\DataCollection\Customer;

class SeedsProvider
{
	private $factoriesPath;

	/**
	 * @var \Illuminate\Database\Eloquent\Factory
	 */
	protected $factory;

	/** @var \Faker\Generator */
	protected $faker;

	public function __construct(Container $container, $factoriesPath = null)
	{

		if (is_null($factoriesPath) or $factoriesPath == '') {
			$factoriesPath = dirname(dirname(__DIR__)) . '/database/factories';
		}
		$this->factoriesPath = $factoriesPath;

		$this->faker =  FakerFactory::create('zh_TW');
		$this->faker->addProvider(new \Faker\Provider\zh_TW\Company($this->faker));

		$this->factory = new EloquentFactory($this->faker);
		$factories = glob($this->factoriesPath . '/*.php');
		foreach ($factories as $factory) {
			require $factory;
		}
	}

	public function all()
	{
		$this->customer();
		$this->supplier();
	}

	public function customer($customerCount = 15)
	{
		$this->factory->of(Customer::class)->times($customerCount)->create();
	}

	public function supplier($supplierCount = 15)
	{
		$this->factory->of(Supplier::class)->times($supplierCount)->create();
	}
}
