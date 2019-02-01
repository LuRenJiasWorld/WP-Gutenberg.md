<?php
/**
 * Plugin Name:       WP Gutenberg.md
 * Plugin URI:        https://github.com/JaxsonWang/WP-Gutenberg.md
 * Description:       Perhaps this is the best and most perfect Markdown editor in WordPress
 * Version:           1.0.0
 * Author:            淮城一只猫
 * Author URI:        https://iiong.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       gmd
 * Domain Path:       /languages
 */

namespace GMDRoot;

use GMD\Main;
use GMDUtils\Activator;
use GMDUtils\Deactivator;

define( 'CAT_GMD_VER', '1.0.0' ); //版本说明
define( 'CAT_GMD_URL', plugins_url( '', __FILE__ ) ); //插件资源路径
define( 'CAT_GMD_PATH', dirname( __FILE__ ) ); //插件路径文件夹
define( 'CAT_GMD_NAME', plugin_basename( __FILE__ ) ); //插件名称

// 自动载入文件
require_once CAT_GMD_PATH . '/vendor/autoload.php';

/**
 * 插件激活期间运行的代码
 * includes/class-plugin-name-activator.php
 */
function activate_gmd() {
	Activator::activate();
}

/**
 * 在插件停用期间运行的代码
 * includes/class-plugin-name-deactivator.php
 */
function deactivate_gmd() {
    Deactivator::deactivate();
}

register_activation_hook( __FILE__, '\GMDRoot\activate_gmd' );
register_deactivation_hook( __FILE__, '\GMDRoot\deactivate_gmd' );

/**
 * 执行插件函数
 */
function run_gmd() {
    $php_version = phpversion();
    $ver = '5.3.0';
    if (version_compare($php_version, $ver) < 0) {
        $a = __("WP Gutenberg.md requires at least version 5.3.0 of PHP. You are running an older version: $php_version. Please upgrade PHP version!",'gmd');
        wp_die( $a, 'WP Gutenberg.md' );
    } else {
        new Main();
    }
}

/**
 * 开始执行插件
 */
run_gmd();