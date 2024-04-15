<?php

class Sigmie_Admin_Results_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'results-page';
	}

	public function options()
	{
		return [];
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
