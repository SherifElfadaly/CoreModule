<?php namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class CMS extends Facade
{
	protected static function getFacadeAccessor() { return 'CMS'; }
}