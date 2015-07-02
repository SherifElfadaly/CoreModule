<?php namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

class SiteController extends Controller {

	/**
	 * Render the given page.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showPage($page = 'home')
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);
		$seo   = \CMS::seo()->getSeo('page', $page->id);

		return view($theme . '::' . $page->template, compact('page', 'seo', 'content'));
	}

	/**
	 * Render the given Content Item.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showContent($page = 'content', $id = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$conntent = false;
		if ($id) $content = \CMS::contentItems()->getContent($id, \Lang::locale());

		return view($theme . '::' . $page->template, compact('page', 'seo', 'content'));
	}

	/**
	 * Render the given Section Content Items.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showSection($page = 'section', $id = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$contents = false;
		if ($id) $contents = \CMS::sections()->getSectionContents($id, \Lang::locale());

		return view($theme . '::' . $page->template, compact('page', 'seo', 'contents'));
	}
}