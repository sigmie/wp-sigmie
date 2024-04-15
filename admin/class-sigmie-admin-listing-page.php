<?php

class Sigmie_Admin_Listing_Page extends Sigmie_Admin_Page
{

	public function component()
	{
		return 'listing-page';
	}

	public function options()
	{
		return [];
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
