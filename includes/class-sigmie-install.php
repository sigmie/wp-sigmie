<?php

class Sigmie_Install
{
	public function install()
	{
		if (!is_blog_installed()) {
			return;
		}

		if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			return;
		}

		wc_switch_to_site_locale();

		$pages = apply_filters(
			'sigmie_create_pages',
			array(
				'product_listing'           => array(
					'name'    => _x('product_listing', 'Product listing', 'sigmie'),
					'title'   => _x('Product listing', 'Product listing', 'sigmie'),
					'content' => "<!-- wp:shortcode -->\n\r[sigmie_product_listing]\n\r<!-- /wp:shortcode -->"
				),
			)
		);

		foreach ($pages as $key => $page) {
			wc_create_page(
				esc_sql($page['name']),
				'sigmie_' . $key . '_page_id',
				$page['title'],
				$page['content'],
				!empty($page['parent']) ? wc_get_page_id($page['parent']) : '',
				!empty($page['post_status']) ? $page['post_status'] : 'publish'
			);
		}

		wc_restore_locale();
	}
}
