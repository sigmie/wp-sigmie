<?php

abstract class Sigmie_Admin_Page
{
	public $slug;

	public $capability = 'manage_options';

	public function __construct()
	{
		$this->slug = $this->slug();

		add_action('admin_menu', array($this, 'add_page'), 11);
	}

	public function render_component()
	{
		$props = [];

		foreach ($this->options() as $value) {
			$props[] = 'sigmie_' . $value;
		}

		$options = get_options($props);

		$props = [];

		foreach ($options as $key => $value) {
			$key = str_replace('sigmie_', '', $key);

			$props[$key] = $value;
		}


		return '<' . $this->component() . '
					 v-bind="' . htmlspecialchars(json_encode($props)) . '">
		</' . $this->component() . '>';
	}

	abstract public function slug();

	abstract public function name();

	abstract public function component();

	abstract public function options();

	public function add_page()
	{
		add_submenu_page(
			'sigmie',
			esc_html__($this->name(), 'sigmie'),
			esc_html__($this->name(), 'sigmie'),
			$this->capability,
			$this->slug,
			array($this, 'display_page'),
		);
	}

	public function display_page()
	{
		require_once dirname(__FILE__) . '/partials/layout.php';
	}
}
