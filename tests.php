<?php
/*
Plugin Name: Tests
Version: 0.1-alpha
Description: PLUGIN DESCRIPTION HERE
Author: YOUR NAME HERE
Author URI: YOUR SITE HERE
Plugin URI: PLUGIN SITE HERE
Text Domain: tests
Domain Path: /languages
*/

//アップグレード通知の無効化
// Thanks to http://www.warna.info/archives/781/
remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );
add_filter( 'pre_site_transient_update_core', '__return_zero' );

//管理画面からのテーマファイル、プラグインファイルの編集停止
if ( ! defined( 'DISALLOW_FILE_EDIT' ) )
  define( 'DISALLOW_FILE_EDIT', true );

//管理画面からの一切のアップグレード(自動アップグレードを含む)を禁止
if ( ! defined( 'DISALLOW_FILE_MODS' ) )
  define( 'DISALLOW_FILE_MODS', true );

//リビジョンを10個に制限
if ( ! defined( 'WP_POST_REVISIONS' ) )
  define( 'WP_POST_REVISIONS', 10 );

//必須プラグインの有効化
// http://dogmap.jp/2012/08/25/must-use-plugins/
new just_do_it();
class just_do_it {
  private $must_plugins = array();
 
  function __construct() {
    if (defined('WPLANG') && WPLANG == 'ja')
      $this->must_plugins['WP Multibyte Patch'] = 'wp-multibyte-patch/wp-multibyte-patch.php';
    if (defined('IS_AMIMOTO') && IS_AMIMOTO)
      $this->must_plugins['Nginx Cache Controller'] = 'nginx-champuru/nginx-champuru.php';
    add_action('shutdown', array($this, 'plugins_loaded'));
  }
 
  public function plugins_loaded() {
    $activePlugins = get_option('active_plugins');
    foreach ($this->must_plugins as $key => $plugin) {
      if ( !array_search($plugin, $activePlugins) && file_exists(WP_PLUGIN_DIR.'/'.$plugin)  && function_exists('activate_plugin')) {
        activate_plugin( $plugin, '', $this->is_multisite() );
      }
    }
  }

  private function is_multisite() {
    return function_exists('is_multisite') && is_multisite();
  }
}

add_action( 'wp_head', 'my_wp_head' );
function my_wp_head()
{
    if ( get_option( 'my_option' ) ) {
        echo '<meta>';
    }
}


