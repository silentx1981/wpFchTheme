<?php

namespace wpFchTheme;

class Index
{

	public function show()
	{
		$this->showHeader();
		$this->showContent();
		$this->showFooter();
	}

	private function showHeader()
	{
		get_header();
	}

	private function showContent()
	{
		include_once('template/index.tpl.php');
	}

	private function showFooter()
	{
		get_footer();
	}
}