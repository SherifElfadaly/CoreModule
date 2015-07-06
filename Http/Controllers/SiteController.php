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
	 * Render the given Content Item or 
	 * all Content Item from the giving 
	 * Content Type.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showContent($page = 'content', $idOrContentType = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$content  = false;
		$contents = [];
		if ($idOrContentType && is_numeric($idOrContentType))
		{
			$seo     = \CMS::seo()->getSeo('contentItem', $idOrContentType);
			$content = \CMS::contentItems()->getContent($idOrContentType, \Lang::locale());
		}
		elseif ($idOrContentType && is_string($idOrContentType))
		{
			$contents = \CMS::contentItems()->getAllContents($idOrContentType, \Lang::locale());
			$contents->setPath(url('contentitem', [$page->page_slug ,$idOrContentType]));
		}

		return view($theme . '::' . $page->template, compact('page', 'seo', 'content', 'contents'));
	}

	/**
	 * Render the given Section Content Items.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showSection($page = 'section', $contentType = false, $id = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$contents = [];
		if ($id) $contents = \CMS::sections()->getSectionContents($contentType, $id, \Lang::locale());

		return view($theme . '::' . $page->template, compact('page', 'seo', 'contents'));
	}

	/**
	 * Render the given Tag Content Items.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showTag($page = 'tag', $contentType = false, $id = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$contents = [];
		if ($id) $contents = \CMS::tags()->getTagContents($contentType, $id, \Lang::locale());

		return view($theme . '::' . $page->template, compact('page', 'seo', 'contents'));
	}

	/**
	 * Render the given Tag Content Items.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showArchive($page = 'archive', $contentType = false, $type = false , $value = false)
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		if ( ! $page || ! view()->exists($theme . '::' . $page->template)) abort(404);

		$seo      = \CMS::seo()->getSeo('page', $page->id);
		$contents = [];
		if ($type && $value) $contents = \CMS::contentItems()->getArchiveContents($contentType, $type, $value, \Lang::locale());

		return view($theme . '::' . $page->template, compact('page', 'seo', 'contents'));
	}
}