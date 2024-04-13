<?php

class Sigmie_Admin_Products_Page extends Sigmie_Admin_Page
{
	public function render_component()
	{
		return '<products-page></products-page>';
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
