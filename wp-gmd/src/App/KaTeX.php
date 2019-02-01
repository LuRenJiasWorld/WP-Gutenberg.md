<?php
/**
 * KaTeX support.
 *
 * Backward compatibility requires support for both "$$katex$$" shortcodes.
 *
 */

namespace GMDApp;

class KaTeX {

	public function __construct() {

		//前端加载资源
		add_action( 'wp_enqueue_scripts', array( $this, 'katex_enqueue_scripts' ) );

	}

	public function katex_enqueue_scripts() {
		wp_enqueue_style( 'Katex', '//cdn.jsdelivr.net/npm/katex@0.10.0/dist/katex.min.css', array(), CAT_GMD_VER, false );

	}

	/**
	 * 获取字段值
	 *
	 * @param string $option  字段名称
	 * @param string $section 字段名称分组
	 * @param string $default 没搜索到返回空
	 *
	 * @return mixed
	 */
	private function get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}

}