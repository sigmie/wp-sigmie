<?php

class Sigmie_Admin_Search_Page extends Sigmie_Admin_Page
{

	public function component()
	{
		return 'search-page';
	}

	public function options()
	{
		return [
			'language',
			'field_text',
			'show_loader',
			'max_height',
			'max_width',
			'corner_radius',
		];
	}

	public function slug()
	{
		return 'sigmie-search-page';
	}

	public function name()
	{
		return 'Search';
	}
}
