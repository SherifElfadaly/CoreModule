<?php namespace App\Modules\Core;

use App\Modules\Core\AbstractRepositories\AbstractRepositoryContainer;

class CMS extends AbstractRepositoryContainer
{	
	/**
	 * Specify module repositories name space.
	 * 
	 * @return array
	 */
	protected function getRepoNameSpace()
	{
		return [
		'App\Modules\Acl\Repositories',
		'App\Modules\Comment\Repositories',
		'App\Modules\Content\Repositories',
		'App\Modules\Gallery\Repositories',
		'App\Modules\Installation\Repositories',
		'App\Modules\Language\Repositories',
		'App\Modules\Menus\Repositories',
		'App\Modules\Widget\Repositories',
		'App\Modules\Slider\Repositories',
		'App\Modules\Pages\Repositories',
		'App\Modules\Seo\Repositories',
				];
	}
}
