<?php

namespace GMDApp;

class PrismJSAuto {

    private $plugin_slug;

    public function __construct($plugin_slug) {

        $this->plugin_slug = $plugin_slug;

        add_action('wp_enqueue_scripts', array($this, 'prism_styles_scripts'));

        add_action('wp_print_footer_scripts', array($this, 'prism_wp_footer_scripts'));
    }

    public function prism_styles_scripts() {
        $prism_base_url = '//cdn.jsdelivr.net/npm/prismjs'; //资源载入地址
        $prism_theme = $this->get_opt('highlight_library_style'); //语法高亮风格
        $line_numbers = $this->get_opt('line_numbers') == 'on' ? true : false; //行号显示
        $show_language = $this->get_opt('show_language') == 'on' ? true : false; //显示语言
        $copy_clipboard = $this->get_opt('copy_clipboard') == 'on' ? true : false; //粘贴
        if ($show_language == true) {
            $toolbar = true;
        } else {
            $toolbar = false;
        }
        $prism_plugins = array(
            'autoloader' => array(
                'js' => true,
                'css' => false
            ),
            'toolbar' => array(
                'js' => $toolbar,
                'css' => $toolbar
            ),
            'line-numbers' => array(
                'css' => $line_numbers,
                'js' => $line_numbers
            ),
            'show-language' => array(
                'js' => $show_language,
                'css' => false
            ),
            'copy-to-clipboard' => array(
                'js' => $copy_clipboard,
                'css' => false
            ),
        );
        $prism_styles = array();
        $prism_scripts = array();

        $prism_scripts['prism-core-js'] = $prism_base_url . '/components/prism-core.min.js';

        if (empty($prism_theme) || $prism_theme == 'default') {
            $prism_styles['prism-theme-default'] = $prism_base_url . '/themes/prism.min.css';
        } else if ($prism_theme == 'customize') {
            $prism_styles['prism-theme-style'] = $this->get_opt('customize_my_style'); //自定义风格
        } else {
            $prism_styles['prism-theme-style'] = $prism_base_url . "/themes/prism-{$prism_theme}.min.css";
        }
        foreach ($prism_plugins as $prism_plugin => $prism_plugin_config) {
            if ($prism_plugin_config['css'] === true) {
                $prism_styles["prism-plugin-{$prism_plugin}"] = $prism_base_url . "/plugins/{$prism_plugin}/prism-{$prism_plugin}.min.css";
            }
            if ($prism_plugin_config['js'] === true) {
                $prism_scripts["prism-plugin-{$prism_plugin}"] = $prism_base_url . "/plugins/{$prism_plugin}/prism-{$prism_plugin}.min.js";
            }
        }

        /**
         * 代码粘贴代码增强
         * 引入clipboard
         */
        if ($copy_clipboard) {
            wp_enqueue_script('copy-clipboard', '//cdn.jsdelivr.net/npm/clipboard/dist/clipboard.min.js', array(), '2.0.1', true);
        }

        foreach ($prism_styles as $name => $prism_style) {
            wp_enqueue_style($name, $prism_style, array(), '1.14.0', 'all');
        }

        foreach ($prism_scripts as $name => $prism_script) {
            wp_enqueue_script($name, $prism_script, array(), '1.14.0', true);
        }
    }

    public function prism_wp_footer_scripts() {
        ?>
        <script type="text/javascript">
            window.Prism !== undefined ?
                (function () {
                    Prism.plugins.autoloader.languages_path = "//cdn.jsdelivr.net/npm/prismjs/components/";

                    var preList = Array.apply(null, document.querySelectorAll('.wp-block-gmd-markdown pre code'));
                    var testReg = /language-html/;
                    preList.map(function (item) {
                        if ( testReg.test(item.getAttribute('class')) ) {
                            item.classList.remove('language-html');
                            item.classList.add('language-markup');
                            item.classList.add('line-numbers');
                        }
                        return item;
                    })
                })()
                :
                undefined;
        </script>
        <?php
    }

    /**
     * 获取选项值
     *
     * @param string $option_data 选项值
     *
     * @return mixed
     */
    public function get_opt($option_data) {
        $options = get_option($this->plugin_slug);
        $val = !empty($options[$option_data]) ? $options[$option_data] : 'off';
        return $val;
    }
}