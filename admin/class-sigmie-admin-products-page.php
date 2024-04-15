<?php

class Sigmie_Admin_Products_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'products-page';
	}

	public function options()
	{
		return [];
	}

	public function slug()
	{
		return 'sigmie-products-page';
	}

	public function name()
	{
		return 'Products';
	}
}
