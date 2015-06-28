<?php namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

class PagesController extends Controller {

	/**
	 * Render the given page.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showPage($page = 'home')
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$seo   = \CMS::seo()->getSeo('page', $page->id);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;

		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		return view($theme . '::' . $page->template, compact('page', 'seo'));
	}
}
