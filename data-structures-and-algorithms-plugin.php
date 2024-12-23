<?php
/**
 * Plugin Name: Data Structures and Algorithms Plugin
 * Plugin URI: https://tangibleplugins.com/data-structures-and-algorithms-plugin
 * Description: Plugin for exploring data structures and algorithms
 * Version: 0.0.1
 * Author: Team Tangible
 * Author URI: https://teamtangible.com
 * License: GPLv2 or later
 */

define( 'DATA_STRUCTURES_AND_ALGORITHMS_PLUGIN_VERSION', '0.0.1' );

require __DIR__ . '/vendor/tangible/framework/index.php';
require __DIR__ . '/vendor/tangible/plugin-updater/index.php';

/**
 * Get plugin instance
 */
function data_structures_and_algorithms_plugin($instance = false) {
  static $plugin;
  return $plugin ? $plugin : ($plugin = $instance);
}

add_action('plugins_loaded', function() {

  $plugin    = tangible\framework\register_plugin([
    'name'           => 'data-structures-and-algorithms-plugin',
    'title'          => 'Data Structures and Algorithms Plugin',
    'setting_prefix' => 'data_structures_and_algorithms_plugin',

    'version'        => DATA_STRUCTURES_AND_ALGORITHMS_PLUGIN_VERSION,
    'file_path'      => __FILE__,
    'base_path'      => plugin_basename( __FILE__ ),
    'dir_path'       => plugin_dir_path( __FILE__ ),
    'url'            => plugins_url( '/', __FILE__ ),
    'assets_url'     => plugins_url( '/assets', __FILE__ ),
  ]);

  data_structures_and_algorithms_plugin( $plugin );

  // tangible_plugin_updater()->register_plugin([
  //   'name' => $plugin->name,
  //   'file' => __FILE__,
  //   // 'license' => ''
  // ]);

  require_once __DIR__.'/includes/index.php';

}, 10);
