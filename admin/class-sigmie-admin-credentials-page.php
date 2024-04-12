<?php

class Sigmie_Admin_Credentials_Page extends Sigmie_Admin_Page
{
	public function __construct()
	{
		$this->slug = $this->slug();

		add_menu_page(
			esc_html__('Sigmie Search'),
			'Sigmie Search',
			$this->capability,
			$this->slug,
			array($this, 'display_page'),
			'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iODBweCIgaGVpZ2h0PSI4MHB4IiB2aWV3Qm94PSIwIDAgODAgODAiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8dGl0bGU+aWNvbi1kYXJrPC90aXRsZT4KICAgIDxnIGlkPSJMb2dvIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyBpZD0iaWNvbi1kYXJrIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCwgMC4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIiBmaWxsLXJ1bGU9Im5vbnplcm8iPgogICAgICAgICAgICA8ZyBpZD0iaWNvbi13aGl0ZSI+CiAgICAgICAgICAgICAgICA8ZyBpZD0ib3V0ZXIiPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xNC4zNTA2NDk0LDIyLjcwMTI5ODcgQzkuMTk0ODg2NzksMjIuNzAxMjk4NyA1LDE4LjUwNjQxMTkgNSwxMy4zNTE5MjcxIEM1LDguMTk0ODg2ODQgOS4xOTQ4ODY3OSw0IDE0LjM1MDY0OTQsNCBDMTkuNTA2NDExOSw0IDIzLjcwMTI5ODcsOC4xOTQ4ODY4NCAyMy43MDEyOTg3LDEzLjM1MTkyNzEgQzIzLjcwMTI5ODcsMTguNTA2NDExOSAxOS41MDY0MTE5LDIyLjcwMTI5ODcgMTQuMzUwNjQ5NCwyMi43MDEyOTg3IEwxNC4zNTA2NDk0LDIyLjcwMTI5ODcgWiBNMTQuMzUwNjQ5NCw4LjY0NDY1ODQ2IEMxMS43NTY3OTYxLDguNjQ0NjU4NDYgOS42NDQ2NTg0NiwxMC43NTY3OTYxIDkuNjQ0NjU4NDYsMTMuMzUxOTI3MSBDOS42NDQ2NTg0NiwxNS45NDU3ODA0IDExLjc1Njc5NjEsMTguMDU2NjQwMiAxNC4zNTA2NDk0LDE4LjA1NjY0MDIgQzE2Ljk0NTc4MDQsMTguMDU2NjQwMiAxOS4wNTY2NDAyLDE1Ljk0NTc4MDQgMTkuMDU2NjQwMiwxMy4zNTE5MjcxIEMxOS4wNTY2NDAyLDEwLjc1Njc5NjEgMTYuOTQ1NzgwNCw4LjY0NDY1ODQ2IDE0LjM1MDY0OTQsOC42NDQ2NTg0NiBMMTQuMzUwNjQ5NCw4LjY0NDY1ODQ2IFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMCwzOS45OTkzNTc5IEMwLDMxLjA2OTk0MzYgMi44NzkyOTYyMywyMi42MjIxMjQ1IDguMzI3MDk5MzYsMTUuNTY5MDA0NiBMMTMuODY4NjUzLDE5Ljg0OTQyMTMgQzkuMzc3NjE4NjgsMjUuNjY0NTIwOSA3LjAwMzAzNDA2LDMyLjYzMjg4MDEgNy4wMDMwMzQwNiwzOS45OTkzNTc5IEM3LjAwMzAzNDA2LDU4LjE5MzM3NjQgMjEuODA1MzM5Myw3Mi45OTY5NjU5IDQwLjAwMDY0MjEsNzIuOTk2OTY1OSBDNTguMTk0NjYwOCw3Mi45OTY5NjU5IDcyLjk5Njk2Niw1OC4xOTMzNzY0IDcyLjk5Njk2NiwzOS45OTkzNTc5IEM3Mi45OTY5NjYsMjEuODA0MDU1IDU4LjE5NDY2MDgsNy4wMDMwMzQwNSA0MC4wMDA2NDIxLDcuMDAzMDM0MDUgQzMzLjk2MDc5ODEsNy4wMDMwMzQwNSAyOC4wNTU4MDA5LDguNjQ2ODc4NDUgMjIuOTIyNjM5OCwxMS43NTg2MjQ2IEwxOS4yOTA3NzExLDUuNzcwMTUwNzQgQzI1LjUxOTQwMDMsMS45OTU3Mjk4NiAzMi42ODAzOTc1LDAgNDAuMDAwNjQyMSwwIEM2Mi4wNTY0MTA5LDAgODAsMTcuOTQzNTg5MiA4MCwzOS45OTkzNTc5IEM4MCw2Mi4wNTUxMjY1IDYyLjA1NjQxMDksODAgNDAuMDAwNjQyMSw4MCBDMTcuOTQzNTg5MSw4MCAwLDYyLjA1NTEyNjUgMCwzOS45OTkzNTc5IFoiIGlkPSJGaWxsLTUiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDwvZz4KICAgICAgICAgICAgICAgIDxnIGlkPSJpbm5lciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTYuMDAwMDAwLCAxNy4wMDAwMDApIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzgsMjIuMzY4Mjg5NiBDMzgsMTguODU1OTAyNCA0MC44NTUxNjEzLDE2IDQ0LjM2NTA1ODIsMTYgQzQ3Ljg3MzY3MTQsMTYgNTAuNzI4ODMyNiwxOC44NTU5MDI0IDUwLjcyODgzMjYsMjIuMzY4Mjg5NiBDNTAuNzI4ODMyNiwyNS44NzkzOTIzIDQ3Ljg3MzY3MTQsMjguNzM3ODY0IDQ0LjM2NTA1ODIsMjguNzM3ODY0IEM0MC44NTUxNjEzLDI4LjczNzg2NCAzOCwyNS44NzkzOTIzIDM4LDIyLjM2ODI4OTYgWiBNNDIsMjIuNSBDNDIsMjMuODc4NTkzMSA0My4xMjE0MDcsMjUgNDQuNTAxODkxLDI1IEM0NS44ODA0ODQxLDI1IDQ3LDIzLjg3ODU5MzEgNDcsMjIuNSBDNDcsMjEuMTIxNDA2OSA0NS44ODA0ODQxLDIwIDQ0LjUwMTg5MSwyMCBDNDMuMTIxNDA3LDIwIDQyLDIxLjEyMTQwNjkgNDIsMjIuNSBaIiBpZD0iRmlsbC0yIj48L3BhdGg+CiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTAsMjMuMDg2NzI2IEMwLDEwLjM1NjA2NDMgMTAuNDQ4MDk0MiwwIDIzLjI5MDI2OTEsMCBDMzQuMjQwMDkzMSwwIDQzLjU3OTM3NzgsNy4zODIyNjk0NSA0Ni4wMDExMTI3LDE3Ljk1MzczMTUgTDQxLjMzMjc4NzMsMTkuMDA1OTE3MSBDMzkuNDEwMTQ4NCwxMC42MDkzMTk5IDMxLjk5MDg2ODksNC43NDUyNzg0IDIzLjI5MDI2OTEsNC43NDUyNzg0IEMxMy4wODg0MzA3LDQuNzQ1Mjc4NCA0Ljc4ODE2MTE4LDEyLjk3MzQ3MzcgNC43ODgxNjExOCwyMy4wODY3MjYgQzQuNzg4MTYxMTgsMzMuMjAxMjgzNiAxMy4wODg0MzA3LDQxLjQyOTQ3ODkgMjMuMjkwMjY5MSw0MS40Mjk0Nzg5IEMzMi4xMTA3MDQ2LDQxLjQyOTQ3ODkgMzkuNzQ0NjM0OSwzNS4yMTI5Njg0IDQxLjQ0MzQwNDgsMjYuNjUwNTgwMiBMNDYuMTQyMDE4NSwyNy41NjU2OTQzIEM0NC4wMDIwOTUsMzguMzQ4NjM3OCAzNC4zOTI4NTA3LDQ2LjE3NDc1NzMgMjMuMjkwMjY5MSw0Ni4xNzQ3NTczIEMxMC40NDgwOTQyLDQ2LjE3NDc1NzMgMCwzNS44MTczODc2IDAsMjMuMDg2NzI2IFoiIGlkPSJGaWxsLTMtQ29weSI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICAgICAgPGcgaWQ9ImNlbnRlciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzQuMDAwMDAwLCAzNC4wMDAwMDApIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTEuOTMzMjgwNyw1Ljk3MDg3Mzc3IEMxMS45MzMyODA3LDkuMjY4ODgzMjIgOS4yNjI1ODY2MywxMS45NDE3NDc1IDUuOTY3MjU1MTgsMTEuOTQxNzQ3NSBDMi42NzE5MjM2MiwxMS45NDE3NDc1IDAsOS4yNjg4ODMyMiAwLDUuOTcwODczNzcgQzAsMi42NzI4NjQzMSAyLjY3MTkyMzYyLDAgNS45NjcyNTUxOCwwIEM5LjI2MjU4NjYzLDAgMTEuOTMzMjgwNywyLjY3Mjg2NDMxIDExLjkzMzI4MDcsNS45NzA4NzM3NyIgaWQ9IkZpbGwtNCI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4='
		);

		add_submenu_page(
			'sigmie',
			esc_html__('Settings', 'sigmie'),
			esc_html__('Settings', 'sigmie'),
			$this->capability,
			$this->slug,
			array($this, 'display_page'),
		);
	}

	public function slug()
	{
		return 'sigmie';
	}

	public function name()
	{
		return 'Credentials';
	}

	public function render_component()
	{
		$options = get_options([
			'sigmie_application_id',
			'sigmie_admin_api_key',
			'sigmie_search_api_key',
			'sigmie_index_prefix',
		]);

		$props = [];

		foreach ($options as $key => $value) {
			$key = str_replace('sigmie_', '', $key);

			$props[$key] = $value;
		}

		return '<credentials-page
					 v-bind="' . htmlspecialchars(json_encode($props)) . '">
		</credentials-page>';
	}
}