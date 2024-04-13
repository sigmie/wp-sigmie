<?php

class Sigmie_Admin_Results_Page extends Sigmie_Admin_Page
{
	public function render_component()
	{
		return '<results-page></results-page>';
	}

	public function slug()
	{
		return 'sigmie-results-page';
	}

	public function name()
	{
		return 'Results';
	}
}
