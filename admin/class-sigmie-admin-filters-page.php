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
			'theme',
			'products_per_page',
			'filters_title_text',
			'products_title_text',
			'products_subtitle_template',

			'sort_by_product_sales_label',
			'sort_by_relevance_label',
			'sort_by_price_desc_label',
			'sort_by_price_asc_label',
			'sort_by_most_recent_label',
			'sort_by_rating_label',

			'show_offers_filter',
			'offers_filter_text',

			'price_range_label',
			'price_range_filter_label',
			'show_price_range_chart',

			'no_products_text',
			'no_products_advice_text',
			'show_categories_filter',
			'reset_filters_text',
		];
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
