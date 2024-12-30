<?php

// Enqueue frontend styles and scripts
add_action('admin_enqueue_scripts', function() use ($plugin) {

  $url = $plugin->url;
  $version = $plugin->version;

  wp_enqueue_style(
    'sorting-styles',
    $url . 'assets/build/sorting.min.css',
    [],
    $version
  );

  // Enqueue frontend script
  wp_enqueue_script(
    'sorting-script',
    $url . 'assets/build/sorting.min.js',
    [],
    $version,
    true
  );

  // wp_enqueue_script(
  //   'sorting',
  //   $url . 'assets/build/sorting.min.js',
  //   ['jquery'],
  //   $version
  // );

});
