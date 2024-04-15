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
			'language' => 'string',
			'field_text' => 'string',
			'show_loader' => 'string',
			'max_height' => 'number',
			'max_width' => 'number',
			'corner_radius' => 'number',
		];
	}

	public function slug()
	{
		return 'sigmie-search-page';
	}

	public function name()
	{
		return 'Search Widget';
	}
}
