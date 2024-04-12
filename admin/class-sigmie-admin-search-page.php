<?php

class Sigmie_Admin_Search_Page extends Sigmie_Admin_Page
{
	public function slug()
	{
		return 'sigmie-search-page';
	}

	public function name()
	{
		return 'Search';
	}

	public function render_component()
	{
		$options = get_options([
			'sigmie_language',
			'sigmie_field_text',
			'sigmie_show_loader',
			'sigmie_max_height',
			'sigmie_max_width',
			'sigmie_corner_radius',
		]);

		$props = [];

		foreach ($options as $key => $value) {
			$key = str_replace('sigmie_', '', $key);

			$props[$key] = $value;
		}

		return '<search-page
					 v-bind="' . htmlspecialchars(json_encode($props)) . '">
		</search-page>';
	}
}