<?php

namespace GMDAdmin;

class Controller {
	/**
	 * @var string 插件名称
	 */
	private $plugin_name;

	/**
	 * @var string 插件版本号
	 */
	private $version;

	/**
	 * @var string 翻译文本域
	 */
	private $text_domain;

	/**
	 * @var string 插件标签
	 */
	private $plugin_slug;

	/**
	 * Controller constructor 初始化类并设置其属性
	 *
	 * @param $plugin_name
	 * @param $version
	 * @param $ioption
	 */
	public function __construct( $plugin_name, $plugin_slug, $version, $text_domain ) {

		$this->plugin_name = $plugin_name;
		$this->text_domain = $text_domain;
		$this->version     = $version;
		$this->plugin_slug = $plugin_slug;

        // Hook: Editor assets.
        add_action( 'init', array($this, 'organic_profile_block') );
	}

	/**
	 * 注册脚本文件
	 */
	public function organic_profile_block() {

	    $style_list = array( 'Editor-Block-Style', 'Editor-Block-Prism' );

        if ( ! function_exists( 'register_block_type' ) ) {
            // Gutenberg is not active.
            return;
        }

        // Style - Style css
        wp_register_style(
                'Editor-Block-Style',
                CAT_GMD_URL . '/assets/editor/editor.css',
                array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
                $this->version,
                'all'
        );

        // Style - KaTeX
        wp_register_style(
            'Editor-Block-KaTeX',
            '//cdn.jsdelivr.net/npm/katex/dist/katex.min.css',
            array(), // Dependency to include the CSS after it.
            $this->version,
            'all'
        );

        // Style - Prism
        wp_register_style(
            'Editor-Block-Prism',
            '//cdn.jsdelivr.net/npm/prismjs/themes/prism.css',
            array(), // Dependency to include the CSS after it.
            $this->version,
            'all'
        );

        // JavaScript - Editor
        wp_register_script(
		        'Editor-Block-Script',
                CAT_GMD_URL . '/assets/editor/editor.js',
            array( 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-editor' ), // Dependencies, defined above.
                $this->version,
                true
        );

        wp_localize_script( 'Editor-Block-Script', 'WP_GMD', array(
            'isKaTeX'  => $this->get_opt( 'enable_katex' ), // 科学公式
            'isMermaid'  => $this->get_opt( 'enable_mermaid' ), // Mermaid
        ) );

        if ( $this->get_opt( 'enable_katex' ) == 'on' ) {
            array_push($style_list, 'Editor-Block-KaTeX');
        }

        register_block_type( 'profile/block', array(
            'editor_script' => 'Editor-Block-Script',
            'editor_style'  => $style_list
        ) );

	}


    /**
     * 获取选项值
     *
     * @param string $option_data 选项值
     *
     * @return mixed
     */
    public function get_opt( $option_data ) {
        $options = get_option( $this->plugin_slug );
        $val     = ! empty( $options[ $option_data ] ) ? $options[ $option_data ] : 'off';

        return $val;
    }

}
