<?php namespace App\Modules\Core\Http\Middleware;

use Closure;

class Initialize {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if( ! is_writable(base_path('storage')))
		{
			return response('Storage folder need write permissions.');
		}
		if ( ! file_exists(base_path('.env')) || 
		   (\CMS::coreModules()->scanModules() === true &&  \CMS::groups()->adminCount() == 0))
		{ 
			if ($request->path() !== 'admin/Installation/setup' && 
				$request->path() !== 'admin/Installation/setup/saveadmin')
			{
				redirect(url('admin/Installation/setup'))->send();
			}
		}
		else
		{		
			$modules = \Module::all();
			$sidebar = array();
			foreach ($modules as $module) 
			{
				if ($module['slug'] == 'acl') 
				{
					$sidebar[] = [
					'Users'       =>[
						'All Users' => ['url' => url('admin/Acl/users'), 'icon'        => 'fa-eye'],
						'Add User'  => ['url' => url('admin/Acl/users/create'), 'icon' => 'fa-plus-circle'],
						'icon'      => 'fa-user',
					],
					'Groups'      => [
						'All Groups' => ['url' => url('admin/Acl/groups'), 'icon'        => 'fa-eye'],
						'Add Group'  => ['url' => url('admin/Acl/groups/create'), 'icon' => 'fa-plus-circle'],
						'icon'       => 'fa-users',
					]
					];
				}
				elseif ($module['slug'] == 'language') 
				{
					$sidebar[] = [
					'Languages' => [
					'All Languages' => ['url' => url('admin/language/'), 'icon'       => 'fa-eye'],
					'Add Language'  => ['url' => url('admin/language/create'), 'icon' => 'fa-plus-circle'],
					'icon'          => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'installation') 
				{
					$sidebar[] = [
					'Installation' => [
					'All Modules' => ['url' => url('admin/Installation'), 'icon'        => 'fa-eye'],
					'Add Modules' => ['url' => url('admin/Installation/create'), 'icon' => 'fa-plus-circle'],
					'icon'        => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'content') 
				{
					
					$contents = [];
					$sections = [];
					foreach (\CMS::sectionTypes()->all() as $sectionTypes) 
					{
						$sections[$sectionTypes->section_type_name] = [
						"All {$sectionTypes->section_type_name}" => ['url' => url('admin/content/sections/show', $sectionTypes->id), 'icon'       => 'fa-eye'],
						"Add {$sectionTypes->section_type_name}"  => ['url' => url('admin/content/sections/create', $sectionTypes->id), 'icon' => 'fa-plus-circle'],
						'icon'               => 'fa-bars',
						];
					}
					foreach (\CMS::contentTypes()->getAllContentTypes() as $contentType) 
					{
						$contents[$contentType->content_type_name] = [
						"All {$contentType->content_type_name}" => ['url' => url('admin/content/show', $contentType->id), 'icon'       => 'fa-eye'],
						"Add {$contentType->content_type_name}"  => ['url' => url('admin/content/create', $contentType->id), 'icon' => 'fa-plus-circle'],
						'icon'               => 'fa-bars',
						];
					}
					$sidebar[] = array_merge([
						'Tags'     => [
						'All Tags' => ['url' => url('admin/content/tags/'), 'icon'       => 'fa-eye'],
						'Add Tag'  => ['url' => url('admin/content/tags/create'), 'icon' => 'fa-plus-circle'],
						'icon'     => 'fa-tags',
						]
					],$sections, $contents);
				}
				elseif ($module['slug'] == 'gallery') 
				{
					$sidebar[] = [
					'Galleries'  => [
					'All Galleries' => ['url' => url('admin/gallery/'), 'icon' => 'fa-eye'],
					'icon'          => 'fa fa-camera',
					],
					'Albums'     => [
					'All Albums' => ['url' => url('admin/gallery/album/'), 'icon'       => 'fa-eye'],
					'Add Album'  => ['url' => url('admin/gallery/album/create'), 'icon' => 'fa-plus-circle'],
					'icon'       => 'fa-picture-o',
					],
					];
				}
				elseif ($module['slug'] == 'comment') 
				{
					$sidebar[] = [
					'Comments'  => [
					'All Comments' => ['url' => url('admin/comment/'), 'icon' => 'fa-comments'],
					'icon'          => 'fa fa-comments',
					]
					];
				}
				elseif ($module['slug'] == 'menus') 
				{
					$sidebar[] = [
						'Menus'  => [
						'All Menus'     => ['url' => url('admin/menus'), 'icon'       => 'fa-eye'],
						'icon'          => 'fa fa-link',
					]
					];
				}
				elseif ($module['slug'] == 'widget') 
				{
					$sidebar[] = [
					'Widgets' => [
					'All Widgets' => ['url' => url('admin/widget/widgettypes/'), 'icon'       => 'fa-eye'],
					'icon'              => 'fa-pencil-square',
					],
					];
				}
				elseif ($module['slug'] == 'slider') 
				{
					$sidebar[] = [
					'Sliders' => [
					'All Sliders' => ['url' => url('admin/slider/'), 'icon'       => 'fa-eye'],
					'icon'        => 'fa-pencil-square',
					],
					];
				}
				elseif ($module['slug'] == 'pages') 
				{
					$sidebar[] = [
					'Pages' => [
					'All Pages' => ['url' => url('admin/pages/'), 'icon'       => 'fa-eye'],
					'icon'        => 'fa-pencil-square',
					],
					];
				}
			}

			$languages  = \CMS::languages()->all();
			
			view()->share('sidebar', $sidebar);
			view()->share('languages', $languages);

			//Set the site language
			\Lang::setlocale(\Session::get('language', \CMS::languages()->getDefaultLanguage()->key));
		}

		return $next($request);
	}

}
