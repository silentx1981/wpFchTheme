<?php

namespace wpFchTheme;

class Pages
{

	public function show($pageId, $pageTitle = null, $display = 'mini')
	{
		if ($pageId === null && $pageTitle !== null) {
			$page = get_page_by_title($pageTitle);
			$pageId = $page->ID;
		}
		if ($pageId === null)
			return "";

		$post_title = apply_filters('the_title', get_post_field('post_title', $pageId));
		$post_content = apply_filters('the_content', get_post_field('post_content', $pageId));
		$post_guid = get_the_guid($pageId);
		$post_display = $display;
		include('template/pages.tpl.php');
		return "";
	}

}