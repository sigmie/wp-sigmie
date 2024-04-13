<?php

class Sigmie_Admin_Listing_Page extends Sigmie_Admin_Page
{
	public function render_component()
	{
		return '<listing-page></listing-page>';
	}

	public function slug()
	{
		return 'sigmie-listing-page';
	}

	public function name()
	{
		return 'Listing';
	}
}
