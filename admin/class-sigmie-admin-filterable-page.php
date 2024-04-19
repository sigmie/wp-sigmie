<?php

class Sigmie_Admin_Filterable_Page extends Sigmie_Admin_Page
{
	public function component()
	{
		return 'filterable-page';
	}

	public function options()
	{
		return [];
	}

	public function slug()
	{
		return 'sigmie-filterable-page';
	}

	public function render_component()
	{
		$filterableAttributes = get_option('sigmie_filterable_attributes');

		$index = get_option('sigmie_index');
		$index = json_decode($index, true);

		$taxonomies = wc_get_attribute_taxonomies();

		$types = [
			'color' => 'color',
			'height' => 'number',
			'material' => 'text',
			'sgm-color' => 'color',
			'width' => 'number',
		];

		$attributes = [];

		foreach ($taxonomies as $key => $taxonomy) {

			$values = [];

			foreach (get_terms('pa_' . $taxonomy->attribute_name, array('hide_empty' => false)) as $term) {
				$values[] = [
					'id' => $term->term_id,
					'label' => $term->name,
				];
			}

			$attributes[] = [
				'name' => $taxonomy->attribute_label,
				'slug' => $taxonomy->attribute_name,
				'type' => $types[$taxonomy->attribute_name],
				'values' => $values
			];
		}

		$attributes[] = [
			'name' => 'Categories',
			'slug' => 'categories',
			'type' => 'text',
			'values' => array_map(function ($term) {
				return [
					'id' => $term->term_id,
					'label' => $term->name,
				];
			}, get_terms('product_cat', array('hide_empty' => false))),
		];

		$attributes[] = [
			'name' => 'Brands',
			'slug' => 'brands',
			'type' => 'text',
			'values' => array_map(function ($term) {
				return [
					'id' => $term->term_id,
					'label' => $term->name,
				];
			}, get_terms('brand', array('hide_empty' => false))),
		];

		$attributes[] = [
			'name' => 'Price',
			'slug' => 'price_as_number',
			'type' => 'text',
			'values' => array_map(function ($product) {
				return [
					'id' => $product->get_id(),
					'label' => $product->get_name(),
				];
			}, wc_get_products(array('status' => 'publish'))),
		];

		$attributes = array_filter($attributes, function ($attribute) use ($filterableAttributes) {
			return !in_array($attribute['name'], array_column($filterableAttributes, 'name'));
		});

		$props = [
			'attributes' => array_values($attributes),
			'filterableAttributes' => $filterableAttributes,
		];


		return '<' . $this->component() . '
					 v-bind="' . htmlspecialchars(json_encode($props)) . '">
		</' . $this->component() . '>';
	}

	public function name()
	{
		return 'Filterable Attributes';
	}
}
