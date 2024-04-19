<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/nicoorfi
 * @since      1.0.0
 *
 * @package    Sigmie
 * @subpackage Sigmie/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sigmie
 * @subpackage Sigmie/admin
 * @author     Nico Orfanos <nico@sigmie.com>
 */
class Sigmie_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie';

	/**
	 * Admin page capabilities.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * Admin page section.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $section = 'sigmie_section_settings';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_settings';

	private $sigmie;

	private $index;



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version, $sigmie, $index)
	{
		$this->index = $index;
		$this->sigmie = $sigmie;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sigmie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sigmie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sigmie-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sigmie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sigmie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// if (get_query_var('page') === 'sigmie') {
		// dd(get_query_var('page'));
		//enqueue your scripts
		// }

		wp_enqueue_script(
			'sigmie-admin-reindex-button',
			plugin_dir_url(__FILE__) . 'js/reindex-button.js',
			array('jquery'),
			$this->version,
			false
		);

		wp_enqueue_script('wp-color-picker');

		if (is_admin() && isset($_GET['page']) && strpos($_GET['page'], 'sigmie') === 0) {

			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url(__FILE__) . 'js/sigmie-admin.js',
				[],
				$this->version,
				[
					'in_footer' => true,
					'strategy'  => 'defer',
				]
			);
		}
	}

	public function add_pages()
	{
		// if (get_option('sigmie_api_is_reachable') === 'yes') {

		new Sigmie_Admin_Credentials_Page;
		new Sigmie_Admin_Search_Page;
		new Sigmie_Admin_Results_Page;
		new Sigmie_Admin_Filterable_Page;
		new Sigmie_Admin_Listing_Page;
		new Sigmie_Admin_Filters_Page;

		// 	add_action('wp_ajax_sigmie_re_index', array($plugin_admin, 're_index'), 10, 2);
		// }
	}

	function display_settings_page()
	{
		require_once dirname(__FILE__) . '/partials/settings.php';
	}

	public function print_section_settings()
	{
		echo '<p>' .
			wp_kses(
				sprintf(
					__('Configure your Sigmie account credentials. You can find them in the <a href="%s" target="_blank">API Keys</a> section of your Sigmie dashboard.', 'sigmie'),
					'https://app.sigmie.com/api-keys'
				),
				[
					'a' => [
						'href'   => [],
						'target' => [],
					],
				]
			) . '</p>';
		echo '<p>' . esc_html__('Once you provide your Sigmie Application ID and API key, this plugin will be able to securely communicate with Sigmie servers.', 'sigmie') . ' ' . esc_html__('We ensure your information is correct by testing them against the Sigmie servers upon save.', 'sigmie') . '</p>';

		echo '<p>' . wp_kses_post(sprintf(__('No Sigmie account yet? <a href="%s">Follow this link</a> to create one for free in a couple of minutes!', 'sigmie'), 'https://app.sigmie.com/sign-up')) . '</p>';
	}

	function product_tab($product_data_tabs)
	{
		$product_data_tabs['sigmie'] = [
			'label'  => __('Sigmie Search', 'sigmie'),
			'target' => 'sigmie',
			'class'    => [],
		];

		return $product_data_tabs;
	}

	function product_tab_content()
	{
?>
		<div id="sigmie" class="panel woocommerce_options_panel hidden">

			<div class="options_group">
				<?php

				woocommerce_wp_text_input([
					'id'    => 'sigmie_boost',
					'label' => __('Boost', 'sigmie'),
					'desc_tip'    => true,
					'description' => __('Enter a value to boost this product in the search results. Higher values will make this product appear higher in the search results.', 'sigmie')
				]);

				?>
			</div>
		</div>
	<?php
	}

	function product_tab_fields($post_id, $post)
	{
		$product = wc_get_product($post);

		if (isset($_POST['sigmie_boost'])) {
			$boost = !empty($_POST['sigmie_boost']) ? sanitize_text_field($_POST['sigmie_boost']) : '1'; // Default value set to '1'
			$product->update_meta_data('sigmie_boost', (int) $boost);
		} else {
			if ($product->meta_exists('sigmie_boost')) {
				$product->delete_meta_data('sigmie_boost');
			}
		}

		$product->save();
	}

	function post_trashed($post_id)
	{
		if (get_post_type($post_id) !== 'product') {
			return;
		}

		$product = wc_get_product($post_id);

		if (!$product->is_type('variable')) {

			$this->sigmie->deleteDocument($this->index, $post_id);

			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function post_untrashed($post_id)
	{
		if (get_post_type($post_id) !== 'product') {
			return;
		}

		$product = wc_get_product($post_id);

		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $post_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	/**
	 * @param  int $order_id Order ID.
	 */
	function order_completed($order_id)
	{
		$order = wc_get_order($order_id);

		$items = $order->get_items();

		foreach ($items as $item_id => $item) {

			$product_id = $item->get_product_id();

			$product = wc_get_product($product_id);

			$this->product_updated($product_id, $product);
		}
	}

	function product_updated($product_id, $product)
	{
		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $product_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function product_created($product_id, $product)
	{
		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $product_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function re_index()
	{
		$page     = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_SPECIAL_CHARS);
		$perPage = 100;

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => $perPage
		);

		$loop = new WP_Query($args);

		$total_pages = ceil($loop->found_posts / $perPage);

		$docs = [];

		while ($loop->have_posts()) : $loop->the_post();

			/** @var  WC_Product_Variable $product */
			global $product;

			if (!$product->is_type('variable')) {

				$docs[] = [
					'_id' => $product->get_id(),
					'action' => 'upsert',
					'body' => $this->map_product($product)
				];

				continue;
			}

			/** @var WC_Product_Variation $variation  */
			foreach ($product->get_available_variations('objects') as $variation) {

				$body[] = [
					'_id' => $variation->get_id(),
					'action' => 'upsert',
					'body' => $this->map_product($variation)
				];
			}

		endwhile;

		wp_reset_postdata();

		$this->sigmie->batchWrite($this->index, $docs);

		$response = array(
			'totalPagesCount' => $total_pages,
			'finished'        => $page >= $total_pages,
		);

		wp_send_json($response);
	}

	/**
	 * @param WC_Product_Variable $product 
	 * 
	 * @return array 
	 */
	function map_product($product)
	{

		$data = $product->get_data();

		$attributes = $product->get_attributes();

		$price = wc_price($data['price']);

		$image_html = $product->get_image();
		preg_match('/src="([^"]*)"/i', $image_html, $image_array);
		$image_url = $image_array[1];

		$gallery_image_ids = $product->get_gallery_image_ids();
		$gallery_images = array_map(function ($image_id) {
			return wp_get_attachment_url($image_id);
		}, $gallery_image_ids);

		$sold_times = get_post_meta($product->get_id(), 'total_sales', true);

		$brands = [];

		$brandTerms = get_the_terms($product->get_id(), 'brand');

		if ($brandTerms) {
			$brands = array_map(fn ($brand) => $brand->name, $brandTerms);
		}

		$tags = [];

		$tagTerms = get_the_terms($product->get_id(), 'product_tag');

		if ($tags) {
			$tags = array_map(fn ($tag) => $tag->name, $tagTerms);
		}

		$res = [
			'thumbnail_html' => $product->get_image(),
			'times_sold' => $sold_times,
			'brands' => $brands,
			'tags' => $tags,
			'image' => $image_url,
			'gallery_image' => $gallery_images,
			'gallery_images' => $gallery_images,
			'link' => $product->get_permalink(),
			'price_as_number' => $product->get_price(),
			'price' => $price,
			'on_sale' => $product->is_on_sale(),
			'price_html' => $product->get_price_html(),
			'review_count' => $data['review_count'],
			'average_rating' => $data['average_rating'],
			'slug' => $data['slug'],
			'name' => $data['name'],
			'sku' => $data['sku'],
			'date_created' => $data['date_created']->date('Y-m-d\TH:i:s.uP'),
			'short_description' => $data['short_description'],
			'description' => $data['description'],
			'stock_status' => $data['stock_status'],
			'is_featured' => $data['featured'],
			'total_sales' => $product->get_total_sales(),
			'categories' => array_map(function ($categoryId) {

				$category = get_term($categoryId, 'product_cat');

				return $category->name;
			}, $data['category_ids']),
			// If featured and no boost set, set to 1.1
			'boost' => array_reduce($data['meta_data'], function ($carry, WC_Meta_Data $metaData) use ($data) {
				if ($metaData->get_data()['key'] === 'sigmie_boost') {
					$carry = (float) $metaData->get_data()['value'];
					if ($data['featured'] && $carry === 1.0) {
						$carry = 1.1;
					}
				}
				return $carry;
			}, 1)
		];

		/** @var WC_Product_Attribute|string $attribute  */
		foreach ($attributes as $name => $attribute) {

			if ($attribute instanceof WC_Product_Attribute) {
				$options = $attribute->get_options();
				$options_text = array_map(function ($option_id) use ($attribute) {
					return get_term_by('id', $option_id, $attribute->get_taxonomy())->name;
				}, $options);

				$attribute = $options_text;
			}

			$res[$name] = $attribute;
		}

		return $res;
	}
	function render_sigmie_product_listing($args)
	{

		$options = get_options([
			'sigmie_application_id',
			'sigmie_search_api_key',
			'sigmie_filterable_attributes',
			'sigmie_theme',
			'sigmie_filterable_attributes',
			'sigmie_show_price_range_chart',
			'sigmie_show_categories_filter',
			'sigmie_products_per_page',
			'sigmie_currency_symbol',
			'sigmie_show_offers_filter',
			'sigmie_products_title_text',
			'sigmie_products_subtitle_template',
			'sigmie_filters_title_text',
			'sigmie_reset_filters_text',
			'sigmie_price_range_label',
			'sigmie_show_products_count',
			'sigmie_price_range_filter_label',
			'sigmie_offers_filter_text',

			//
			'sigmie_offers_filter_text',
			'sigmie_no_products_text',
			'sigmie_no_products_advice_text',
			'sigmie_sort_by_relevance_label',
			'sigmie_sort_by_price_desc_label',
			'sigmie_sort_by_price_asc_label',
			'sigmie_sort_by_most_recent_label',
			'sigmie_sort_by_rating_label',
			'sigmie_sort_by_product_sales_label',

			'sigmie_filters_order',
			'sigmie_range_attributes',
			'sigmie_checkbox_attributes',
			'sigmie_selectbutton_attributes',
			'sigmie_color_attributes_color',
		]);

		$predefinedFilters = '';

		if ($args['categories'] ?? false) {
			$categories = explode(',', $args['categories'] ?? '');
			$categories = array_map(fn ($category) => "'{$category}'", $categories);

			$predefinedFilters = "categories:[" . implode(',', $categories) . "]";
		}

		$filterableAttributes = get_option('sigmie_filterable_attributes');

		// --------- 
		$selectButtonFilterableAttributes = array_filter($filterableAttributes, function ($attribute) {
			return $attribute['type'] === 'selectbutton';
		});

		$selectButtonAttributes = [];
		foreach ($selectButtonFilterableAttributes as $attribute) {
			$selectButtonAttributes[] = $attribute['slug'];
		}

		// --------- Colors
		$colorFilterableAttributes = array_filter($filterableAttributes, function ($attribute) {
			return $attribute['type'] === 'color';
		});
		$colorAttributes = [];
		foreach ($colorFilterableAttributes as $attribute) {
			$name = 'pa_' . $attribute['slug'];
			$colorAttributes[$name] = [];

			foreach ($attribute['values'] as $value) {
				$colorAttributes[$name][$value['label']] =
					'#' . $value['color_hex_1'] . '|' .
					'#' . $value['color_hex_2'] . '|' .
					'#' . $value['color_hex_3'];
			}
		}
		// --------- End Colors

		$sortedAttributes = [];
		$attributeLabels = [];

		foreach (wc_get_attribute_taxonomies() as $attribute) {
			$attributeLabels['pa_' . $attribute->attribute_name] = $attribute->attribute_label;
			$sortedAttributes['pa_' . $attribute->attribute_name] = array_map(function (WP_Term $term) {
				return $term->name;
			}, get_terms([
				'taxonomy' => 'pa_' . $attribute->attribute_name,
				'hide_empty' => false,
			]));
		}

		// $attributes = [];
		// if ($options['sigmie_filters_order']) {
		// 	$attributes = json_decode($options['sigmie_filters_order']);
		// }

		// dd($attributes);
		$attributes = array_map(function ($attribute) {

			if (in_array($attribute['slug'], ['categories', 'brands', 'tags', 'price_as_number'])) {
				return $attribute['slug'];
			}

			return 'pa_' . $attribute['slug'];
		}, $filterableAttributes);

		// dd($attributes);



		$facets = implode(' ', $attributes);

		$numberFacets = ['price_as_number', ...json_decode($options['sigmie_range_attributes'], true)];
		$checkboxFacets = ['categories', 'brands', ...json_decode($options['sigmie_checkbox_attributes'], true)];
		$selectButtonFacets  = [...$selectButtonAttributes];
		$colorFacets = [...array_keys($colorAttributes)];

		$facetTypes = array_merge(
			array_fill_keys($numberFacets, 'number-facet'),
			array_fill_keys($checkboxFacets, 'checkbox-facet'),
			array_fill_keys($selectButtonFacets, 'selectbutton-facet'),
			array_fill_keys($colorFacets, 'color-facet')
		);

		$facetProps = [];

		foreach ($attributes as $attribute) {
			$facetProps[$attribute] = [
				'name' => $attribute
			];
		}

		foreach ($attributes as $index => $attribute) {
			$facetProps[$attribute]['expanded'] = true;
		}

		foreach ($numberFacets as $attribute) {
			$facetProps[$attribute]['step'] = 1;
			$facetProps[$attribute]['from_label'] = 'from % $';
			$facetProps[$attribute]['to_label'] = 'to % $';
			$facetProps[$attribute]['operator'] = 'AND';
		}

		foreach ($attributeLabels as $attribute => $attributeLabel) {
			$facetProps[$attribute]['label'] = $attributeLabel;
		}

		foreach ($facetTypes as $key => $type) {
			$facetProps[$key]['component'] = $type;
		}

		foreach ($sortedAttributes as $key => $values) {
			$facetProps[$key]['sorted_values'] = $values;
			$facetProps[$attribute]['operator'] = 'OR';
		}

		foreach ($colorAttributes as $key => $value) {
			$facetProps[$key]['value_colors'] = $value;
			$facetProps[$key]['operator'] = ' OR ';
		}

		$facetProps['price_as_number']['symbol'] = get_woocommerce_currency_symbol();
		$facetProps['price_as_number']['label'] = $options['sigmie_price_range_label'];
		$facetProps['price_as_number']['step'] = 1;
		$facetProps['price_as_number']['from_label'] = 'from % $';
		$facetProps['price_as_number']['to_label'] = 'to % $';
		$facetProps['price_as_number']['operator'] = ' AND ';


		$facetProps['categories']['label'] = 'Categories';
		$facetProps['categories']['operator'] = ' OR ';

		$facetProps['brands']['label'] = 'Brands';
		$facetProps['brands']['operator'] = ' OR ';

		$facetProps = array_filter($facetProps, function ($prop) {
			return !is_null($prop['component'] ?? null);
		});

		$index = 0;
		$facetProps = array_map(function ($prop) use (&$index) {
			$prop['index'] = $index;

			$index++;

			return $prop;
		}, $facetProps);

		$props = [
			'facets' => $facetProps,
			'sigmie' => [
				'filters' => $predefinedFilters,
				'facets' => $facets,
				'application' => $options['sigmie_application_id'],
				'api_key' => $options['sigmie_search_api_key'],
				'index' => $this->index,
			],
			'options' => [
				'show_offers_filter' => $options['sigmie_show_offers_filter'] === '1',
				'per_page' => (int) $options['sigmie_products_per_page']
			],
			'texts' => [
				'products_title_text' => $options['sigmie_products_title_text'],
				'products_subtitle_template' => $options['sigmie_products_subtitle_template'],
				'filters_title_text' => $options['sigmie_filters_title_text'],
				'offers_filter_text' => $options['sigmie_offers_filter_text'],
				'reset_filters_text' => $options['sigmie_reset_filters_text'],
				'price_range_filter_label' => $options['sigmie_price_range_filter_label'],
				'offers_filter_text' => $options['sigmie_offers_filter_text'],
				'no_products_text' => $options['sigmie_no_products_text'],
				'no_products_advice_text' => $options['sigmie_no_products_advice_text'],
			],
			'sort' => [
				'default_option' => [
					'label' => $options['sigmie_sort_by_relevance_label'],
					'value' => "_score",
				],
				'options' => [
					[
						'label' => $options['sigmie_sort_by_relevance_label'],
						'value' => "_score",
					],
					[
						'label' => $options['sigmie_sort_by_price_desc_label'],
						'value' => "price_as_number:desc",
					],
					[
						'label' => $options['sigmie_sort_by_price_asc_label'],
						'value' => "price_as_number:asc",
					],
					[
						'label' => $options['sigmie_sort_by_product_sales_label'],
						'value' => "total_sales:desc",
					],
					[
						'label' => $options['sigmie_sort_by_rating_label'],
						'value' => "average_rating:desc",
					],
					[
						'label' => $options['sigmie_sort_by_most_recent_label'],
						'value' => "date_created:desc",
					]
				]
			]
		];

		return '<div class="" id="sigmie-filters">
					<product-listing v-bind="' . htmlspecialchars(json_encode($props)) . '">
					</product-listing>
				</div>';
	}

	function render_sigmie_search_bar()
	{
		$options = get_options([
			'sigmie_nothing_found_text',
			'sigmie_sort_by',
			'sigmie_number_of_results',
			'sigmie_max_description_length',
			'sigmie_show_category',
			'sigmie_show_description',
			'sigmie_show_price',
			'sigmie_show_rating',
			'sigmie_show_sku',
			'sigmie_show_stock',
			'sigmie_show_on_sale',
			'sigmie_application_id',
			'sigmie_search_api_key',

			'sigmie_search_field_text',
			'sigmie_show_loader',
			'sigmie_search_field_height',
			'sigmie_search_field_width',
			'sigmie_corner_radius',
			'sigmie_show_categories',
			'sigmie_number_of_categories'
		]);

		return '<div class="container flex flex-wrap items-center justify-between mx-auto" id="sigmie-search">
			<search 
				search-field-text="' . (string) $options['sigmie_search_field_text'] . '" 
				:show-loader="' . (string) ($options['sigmie_show_loader'] === '1' ? 'true' : 'false') . '" 
				search-field-height="' . (int) $options['sigmie_search_field_height'] . '" 
				search-field-width="' . (int) $options['sigmie_search_field_width'] . '" 
				corner-radius="' . (int) $options['sigmie_corner_radius'] . '" 
				:show-categories="' . (string) ($options['sigmie_show_categories'] === '1' ? 'true' : 'false') . '" 


				nothing-found-text="' . $options['sigmie_nothing_found_text'] . '" 
				sort-by="' . $options['sigmie_sort_by'] . '"
				number-of-results="' . $options['sigmie_number_of_results'] . '"
				number-of-categories="' . $options['sigmie_number_of_categories'] . '"
				max-description-length="' . $options['sigmie_max_description_length'] . '"
				:show-category="' . ($options['sigmie_show_category'] === '1' ? 'true' : 'false') . '"
				:show-description="' . ($options['sigmie_show_description'] === '1' ? 'true' : 'false') . '"
				:show-price="' . ($options['sigmie_show_price'] === '1' ? 'true' : 'false') . '"
				:show-rating="' . ($options['sigmie_show_rating'] === '1' ? 'true' : 'false') . '"
				:show-sku="' . ($options['sigmie_show_sku'] === '1' ? 'true' : 'false') . '"
				:show-stock="' . ($options['sigmie_show_stock'] === '1' ? 'true' : 'false') . '"
				:show-on-sale="' . ($options['sigmie_show_on_sale'] === '1' ? 'true' : 'false') . '"
				application="' . $options['sigmie_application_id'] . '" 
				api-key="' . $options['sigmie_search_api_key'] . '" 
				index="' . $this->index . '">

			</search>
		</div>';
	}

	function register_sigmie_widget()
	{
		register_widget('Sigmie_Search_Widget');
	}

	function sigmie_template_include($template)
	{
		if (get_post(get_the_ID())->post_name === 'shop' && (int) get_option('woocommerce_shop_page_id') === (int)get_option('sigmie_product_listing_page_id')) {
			$new_template = plugin_dir_path(__FILE__) . 'class-sigmie-filters-template.php';
			if (file_exists($new_template)) {
				return $new_template;
			}
		}

		return $template;
	}

	function add_display_post_states($post_states, $post)
	{
		if ((int)get_option('sigmie_product_listing_page_id') === $post->ID) {
			$post_states['sigmie_product_listing_page'] = __('Sigmie product listing', 'sigmie');
		}

		return $post_states;
	}

	function register_attribute_types($types)
	{
		$types = array_merge([
			'sgm-buttonselect' => esc_html__('Button Select', 'sigmie'),
			'sgm-number' => esc_html__('Number', 'sigmie'),
			'sgm-color' => esc_html__('Color', 'sigmie'),
		], $types);

		return $types;
	}

	function attribute_orderby_field()
	{

	?>
		<div class="form-field">
			<label for="sigmie_attribute_facets_orderby"><?php esc_html_e('Facets sort order', 'sigmie'); ?></label>
			<select name="sigmie_attribute_facets_orderby" id="sigmie_attribute_facets_orderby">
				<option value="top"><?php esc_html_e('Top', 'sigmie'); ?></option>
				<option value="asc"><?php esc_html_e('Ascending', 'sigmie'); ?></option>
				<option value="desc"><?php esc_html_e('Descending', 'sigmie'); ?></option>
			</select>
			<p class="description"><?php esc_html_e('Determines the sort order of the facets on the frontend shop product pages.', 'sigmie'); ?></p>
		</div>
<?php
	}

	public function rest_save_settings(WP_REST_Request $value)
	{
		try {

			$body = $value->get_body();

			$data = json_decode($body, true);

			$data = array_filter($data, function ($key) {
				return in_array($key, [
					"language",
					"field_text",
					"show_loader",
					"max_height",
					"max_width",
					"corner_radius",

					"application_id",
					"admin_api_key",
					"search_api_key",
					"index_prefix",

					"theme",
					"products_per_page",
					"filters_title_text",
					"products_title_text",
					"products_subtitle_template",

					"sort_by_product_sales_label",
					"sort_by_relevance_label",
					"sort_by_price_desc_label",
					"sort_by_price_asc_label",
					"sort_by_most_recent_label",
					"sort_by_rating_label",

					"show_offers_filter",
					"offers_filter_text",

					"price_range_label",
					"price_range_filter_label",
					"show_price_range_chart",

					"no_products_text",
					"no_products_advice_text",
					"show_categories_filter",
					"reset_filters_text",

					"nothing_found_text",
					"sort_by",
					"number_of_results",
					"show_categories",
					"number_of_categories",
					"max_description_length",
					"show_category",
					"show_description",
					"show_price",
					"show_rating",
					"show_sku",
					"show_on_sale",

					"filterable_attributes",

					'language',
					'field_text',
					'show_loader',
					'max_height',
					'max_width',
					'corner_radius'
				]);
			}, ARRAY_FILTER_USE_KEY);

			foreach ($data as $key => $value) {

				update_option('sigmie_' . $key, $value);
			}

			return new WP_REST_Response(array('success' => true, 'message' => 'Your changes have been saved!'), 200);
		} catch (Throwable $e) {

			return new WP_REST_Response(array('success' => false, 'message' => $e->getMessage()), 500);
		}
	}

	public function register_rest_route($value)
	{
		register_rest_route('/v1/sigmie', '/save-settings', array(
			'methods' => 'POST',
			'callback' => [$this, 'rest_save_settings'],
			'permission_callback' => function () {
				return current_user_can($this->capability);
			}
		));
	}
}
