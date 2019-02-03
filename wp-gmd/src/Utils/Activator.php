<?php

namespace GMDUtils;

class Activator {

    public static function activate() {

        // 初次载入插件写入默认数据 => 判断本地是否存在数据 不存在写入数据即可
        if (get_option('wp-gmd-settings') == false) {
            add_option('wp-gmd-settings', Activator::$defaultOptions, '', 'yes');
        }

    }

    public static $defaultOptions = array(
        'enable_katex' => 'off',
        'enable_mermaid' => 'off'
    );
}
