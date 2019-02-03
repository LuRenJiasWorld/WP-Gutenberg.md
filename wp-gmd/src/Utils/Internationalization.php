<?php

namespace GMDUtils;

class Internationalization {

    /**
     * @access   private
     * @var      string $domain The domain identifier for this plugin.
     */
    private $domain;

    /**
     * 指定文件夹
     */
    public function __construct( $text_domain ) {
        $this->domain = $text_domain;
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
    }

    /**
     * 指定文件夹
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            $this->domain,
            false,
            dirname(CAT_GMD_NAME) . '/languages/'
        );
    }

}