<?php

class Sigmie_Admin_Filters_Page extends Sigmie_Admin_Page
{
	public function render_component()
	{
		return '<filters-page></filters-page>';
	}

	public function slug()
	{
		return 'sigmie-filters-page';
	}

	public function name()
	{
		return 'Filters';
	}
}
