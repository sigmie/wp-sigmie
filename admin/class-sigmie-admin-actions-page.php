<?php

class Sigmie_Admin_Actions_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'actions-page';
	}

	public function options()
	{
		return [];
	}

	public function slug()
	{
		return 'sigmie-actions';
	}

	public function name()
	{
		return 'Actions';
	}
}
