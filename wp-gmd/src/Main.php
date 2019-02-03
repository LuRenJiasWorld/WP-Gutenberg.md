<?php

namespace GMD;

use GMDAdmin\Controller;
use GMDApp\KaTeX;
use GMDApp\Mermaid;
use GMDApp\PrismJSAuto;
use GMDUtils\Guide;
use GMDUtils\Internationalization;
use GMDUtils\PluginMeta;
use GMDUtils\Settings;

/**
 * 核心插件类
 * Class Main
 *
 * @package GMD
 */
class Main {
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * textdomain
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $text_domain
     */
    protected $text_domain;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'WP Gutenberg.md';
        $this->plugin_slug = 'wp-gmd-settings';
        $this->text_domain = 'gmd';
        $this->version = CAT_GMD_VER;

        $this->run_core();
    }

    /**
     * 实现方法
     *
     * @return void
     */
    public function run_core() {
        // 实现国际化
        new Internationalization();

        new Controller($this->get_plugin_name(), $this->get_plugin_slug(), $this->get_version(), $this->get_text_domain());

        // 实现插件meta信息
        new PluginMeta($this->get_text_domain());

        // 实现欢迎页面提醒
        new Guide($this->get_text_domain());

        // 实现设置类
        new Settings($this->get_plugin_name(), $this->get_plugin_slug(), $this->get_version(), $this->get_text_domain());

        // 实现KaTeX
        $this->get_opt( 'enable_katex' ) == 'on' ? new KaTeX() : null;

        // 实现Mermaid
        $this->get_opt( 'enable_mermaid' ) == 'on' ? new Mermaid() : null;

        // 实现语法高亮
        $this->get_opt( 'enable_highlight' ) == 'on' ? new PrismJSAuto( $this->get_plugin_slug() ) : null;
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

	/**
	 * Get slug
	 * @return string
	 */
    public function get_plugin_slug() {
    	return $this->plugin_slug;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_text_domain() {
        return $this->text_domain;
    }

	/**
	 * 获取选项值
	 * @param string $option_data 选项值
	 *
	 * @return mixed
	 */
	public function get_opt($option_data) {
		$options = get_option( $this->get_plugin_slug() );
		$val = !empty($options[$option_data]) ? $options[$option_data] : 'off';
		return $val;
	}

}
