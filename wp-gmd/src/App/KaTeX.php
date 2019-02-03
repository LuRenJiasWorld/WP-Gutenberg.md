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
		// 前端加载资源
		add_action( 'wp_enqueue_scripts', array( $this, 'katex_enqueue_scripts' ) );
	}

	public function katex_enqueue_scripts() {
		wp_enqueue_style( 'Katex', '//cdn.jsdelivr.net/npm/katex/dist/katex.min.css', array(), CAT_GMD_VER, 'all' );
	}
}