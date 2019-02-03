<?php
/**
 * Mermaid support.
 *
 *
 */

namespace GMDApp;

class Mermaid {

    public function __construct() {
        // 取消内容转义
        remove_filter('the_content', 'wptexturize');
        // 取消摘要转义
        remove_filter('the_excerpt', 'wptexturize');
        // 取消评论转义
        remove_filter('comment_text', 'wptexturize');
        // 引入Mermaid脚本
        add_action('wp_enqueue_scripts', array($this, 'mermaid_enqueue_scripts'));
        // 执行脚本
        add_action('wp_print_footer_scripts', array($this, 'mermaid_wp_footer_script'));
    }

    public function mermaid_enqueue_scripts() {
        wp_enqueue_script(
            'Mermaid',
            '//cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js',
            array(),
            CAT_GMD_VER,
            true
        );
    }

    public function mermaid_wp_footer_script() {
        ?>
        <script type="text/javascript">
            window.mermaid !== undefined ?
                mermaid.initialize({
                    theme: 'default',
                    gantt: {
                        axisFormatter: [
                            ['%Y-%m-%d', (d) => {
                                return d.getDay() === 1
                            }]
                        ]
                    }
                })
                : '';
        </script>
        <?php
    }

}