<?php

class Sigmie_Admin_Results_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'results-page';
	}

	public function options()
	{
		return [
			'nothing_found_text' => 'string',
			'sort_by' => 'string',
			'number_of_results' => 'number',
			'show_categories' => 'string',
			'number_of_categories' => 'number',
			'max_description_length' => 'number',
			'show_category' => 'string',
			'show_description' => 'string',
			'show_price' => 'string',
			'show_rating' => 'string',
			'show_sku' => 'string',
			'show_on_sale' => 'string',
		];
	}

	public function slug()
	{
		return 'sigmie-results-page';
	}

	public function name()
	{
		return 'Search Results';
	}
}
