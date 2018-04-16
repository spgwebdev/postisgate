<?php
namespace SeniorProgramming\PostisGate\Facades;

use Illuminate\Support\Facades\Facade;

class PostisGate extends Facade  {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'postisgate'; }
}