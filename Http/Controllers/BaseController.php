<?php namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller {

	/**
	 * The modulePart implementation.
	 * 
	 * @var modulePart
	 */
	protected $modulePart;

	/**
	 * Create new BaseController instance.
	 * 
	 * @param moduleParts
	 */
	protected function __construct($modulePart)
	{
			$this->modulePart = $modulePart;
			$this->checkAdmin();
	}

	/**
	 * Check if the admin only is set to true then allow 
	 * for admin users only else check the given permissions.
	 * 
	 * @param permission
	 */
	private function checkAdmin()
	{	
		$adminOnly = property_exists($this, 'adminOnly') ? $this->adminOnly : false;
		if ($adminOnly) 
		{
			$this->checkLogin(true);
		}
		else
		{
			$this->checkPermission();
		}
	}

	/**
	 * Return a list of route actions with permissions.
	 * 
	 * @param permission
	 */
	private function getRouteActionPermissions()
	{	
		$extraPermissions = property_exists($this, 'permissions') ? $this->permissions : array();

		return array_merge([
			'getIndex'   => 'show', 
			'getCreate'  => 'add', 
			'getEdit'    => 'edit', 
			'postCreate' => 'add',
			'postEdit'   => 'edit', 
			'getDelete'  => 'delete'
			], $extraPermissions);
	}	

	/**
	 * Check the permissions passed on the called route action.
	 * 
	 * @param permission
	 */
	private function checkPermission()
	{
		foreach ($this->getRouteActionPermissions() as $routeAction => $permission) 
		{
			if (explode('@', \Route::currentRouteAction())[1] === $routeAction)
			{
				$this->checkLogin();
				$this->hasPermission($permission);
			}
		}
	}

	/**
	 * Redirect the user to teh login page if not logged in
	 * and if admin is true then allow admin users only.
	 * 
	 * @param permission
	 */
	private function checkLogin($admin = false)
	{
		if (\Auth::guest())
		{
			if (\Request::ajax())
			{
				response('Unauthorized.', 401)->send();
			}
			else
			{
				return redirect()->guest('admin/Acl/login')->send();
			}
		}	
		elseif ($admin && ! \CMS::users()->userHasGroup(\Auth::user()->id, 'admin')) 
		{
			abort(403, 'Unauthorized');
		}
	}

	/**
	 * Throw exception if the user don't have the permission.
	 * 
	 * @param permission
	 */
	protected function hasPermission($permission)
	{
		if ( ! \CMS::permissions()->can($permission, $this->modulePart)) 
		{
			abort(403, 'Unauthorized');
		}
		return true;
	}
}
