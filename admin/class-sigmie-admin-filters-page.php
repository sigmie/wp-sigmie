<?php

class Sigmie_Admin_Filters_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'filters-page';
	}

	public function options()
	{
		return	[
			'theme' => 'string',
			'products_per_page' => 'string',
			'filters_title_text' => 'string',
			'products_title_text' => 'string',
			'products_subtitle_template' => 'string',

			'sort_by_product_sales_label' => 'string',
			'sort_by_relevance_label' => 'string',
			'sort_by_price_desc_label' => 'string',
			'sort_by_price_asc_label' => 'string',
			'sort_by_most_recent_label' => 'string',
			'sort_by_rating_label' => 'string',

			'show_offers_filter' => 'string',
			'offers_filter_text' => 'string',

			'price_range_label' => 'string',
			'price_range_filter_label' => 'string',
			'show_price_range_chart' => 'string',

			'no_products_text' => 'string',
			'no_products_advice_text' => 'string',
			'show_categories_filter' => 'string',
			'reset_filters_text' => 'string',
		];
	}

	public function slug()
	{
		return 'sigmie-filters-page';
	}

	public function name()
	{
		return 'Filter Settings';
	}
}
