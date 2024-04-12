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

	abstract public function render_component();

	abstract public function slug();

	abstract public function name();

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
