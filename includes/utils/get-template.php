<?php
/**
 * Get Plugins template and pass data to be used in template
 *
 *
 * @param  string $name template name
 * @param  array  $args data for template
 * @param array $tmp_paths_info template paths info:
 *             'plugin_tmp_path' plugin templates dir path (relative to plugins dir);
 *             'override_tmp_path' plugin override sub-directory(relative to active theme's plugin override directory )
 *
 * @param  boolean $admin   if we are looking a template for wp backend
 * @param  boolean $echo echo or return
 * @param  boolean  $return_file_path  return just file path instead of output
 *
 *
 * @return mixed
 *
 */
$plugin -> get_template = function ($name, $args, $tmp_paths_info =[], $admin = false, $echo = false, $return_file_path = false) use($plugin){

  $plugin_tmp_path = isset($tmp_paths_info['plugin_tmp_path']) && !empty($tmp_paths_info['plugin_tmp_path']) ? $tmp_paths_info['plugin_tmp_path'] : 'includes/templates';

  $override_tmp_path = isset($tmp_paths_info['override_tmp_path']) && !empty($tmp_paths_info['override_tmp_path']) ? $tmp_paths_info['override_tmp_path'].'/' : '';

  $plugin_dir_name = $plugin->name;
  $plugin_dir =  $plugin->dir_path;

  $admin_templates = ( $admin ) ? 'admin-templates/' : '' ;

  $template_paths = [];
  $file_pathinfo = pathinfo($name);

  if ( ! isset( $file_pathinfo['dirname'] ) ) {
    $file_pathinfo['dirname'] = '';
  } elseif ( ! empty( $file_pathinfo['dirname'] ) ) {
    if ( '.' === $file_pathinfo['dirname'] ) {
      $file_pathinfo['dirname'] = '';
    } else {
      $file_pathinfo['dirname'] .= '/';
    }
  }

  if ( !isset( $file_pathinfo[ 'extension' ] ) ) {
    $file_pathinfo['extension'] = 'php';
  }

  // If for some reason the $name has an extension we reset the $name to be without it.
  if ( $file_pathinfo[ 'extension' ] == 'php' ) {

    $template_filename= $file_pathinfo['dirname'] . $file_pathinfo['filename'] . '.' . $file_pathinfo['extension'];

    $t_arr= [
      $plugin_dir_name . '/' . $template_filename,
      $plugin_dir_name . '/' .$override_tmp_path.$template_filename,
      $template_filename
    ];

    $template_paths = array_merge( $template_paths, $t_arr);
  }

  $filepath = '';

  // locate templates in the theme first
  if( !$admin_templates ){
    $filepath = locate_template( $template_paths );
  }

  // if not found in the theme try to find it in plugin's templates
  if ( !$filepath ) {
    $template_files = [];

    foreach ($template_paths as $template_path) {
      $template_file = basename( $template_path );
      if ( !array_key_exists( $template_file, $template_files ) ) {
        $template_files[ $template_file ] = $template_file;
      }
    }

    if ( !empty( $template_files ) ) {
      foreach ( $template_files as $template_file ) {
        if(file_exists( $plugin_dir . $plugin_tmp_path .'/'. $admin_templates . $template_filename)) {
          $filepath = $plugin_dir . $plugin_tmp_path .'/'. $admin_templates . $template_filename;
          break;
        }
      }
    }
  }

  // no templates
  if ( !$filepath ) {
    return false;
  }

  /**
   * Filter filepath for template being called
   *
   */
  $filepath = apply_filters($plugin_dir_name . '_template', $filepath, $name, $args, $echo, $return_file_path, $admin);

  if ( $return_file_path ) {
    return $filepath;
  }

  // Added check to ensure external hooks don't return empty or non-accessible filenames.
  if ((!empty( $filepath ) ) && (file_exists( $filepath )) && (is_file( $filepath ))) {

    extract($args);

    ob_start();
    include( $filepath );
    $contents = ob_get_clean();

    if ( !$echo ) {
      return $contents;
    }
    echo $contents;
  }
};
