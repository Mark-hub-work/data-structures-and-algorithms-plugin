<?php

// Enqueue frontend styles and scripts

add_action('wp_enqueue_scripts', function() use ($plugin) {

  $url = $plugin->url;
  $version = $plugin->version;

  wp_enqueue_style(
    'data-structures-and-algorithms-plugin',
    $url . 'assets/build/data-structures-and-algorithms-plugin.min.css',
    [],
    $version
  );

  wp_enqueue_script(
    'data-structures-and-algorithms-plugin',
    $url . 'assets/build/data-structures-and-algorithms-plugin.min.js',
    ['jquery'],
    $version
  );

});
