<?php

$plugin->templates_path = function ($templates_dir_path, $files_dir = '' ) {
  if(empty($templates_dir_path)) return;
  if(!empty($files_dir)) $files_dir = $files_dir.'/';

  return $templates_dir_path.$files_dir;
};


$plugin->dir_files = function ($path, $include_hidden = true, $recursive = true) use($plugin) {
  $files=[];
  if(empty($path) || empty($plugin) || empty($framework)) return $files;

  $filesystem = $framework->filesystem()->dirlist($path, $include_hidden,$recursive);

  foreach($filesystem as $fs_key => $fs_type){
    if($fs_type['type'] === 'd'){
      foreach($fs_type['files'] as $file => $data ){
        $files[]=$data;
      }
    } elseif($fs_type['type'] === 'f'){
      $files[]=$fs_type;
    }
  }

  return $files;
};

// File system utilities
$plugin->filesystem = function() {
  static $o;
  if ($o) return $o;
  return $o = new class {

    function get( $path ) {
      return $this->fs()->get_contents( $path );
    }

    function is_writable( $path ) {
      return $this->fs()->is_writable( $path );
    }

    function put( $path, $contents ) {
      return $this->fs()->put_contents( $path, $contents, FS_CHMOD_FILE );
    }

    function mkdir( $path ) {
      return $this->fs()->mkdir( $path );
    }

    function rmdir( $path, $recursive = false ) {
      return $this->fs()->rmdir( $path, $recursive );
    }

    function is_dir( $path ) {
      return $this->fs()->is_dir( $path );
    }

    /**
     * @return array [ $filename => $fileinfo, .. ]
     */
    function dirlist( $path, $include_hidden = true, $recursive = false ) {
      return (array) $this->fs()->dirlist( $path, $include_hidden, $recursive );
    }

    function move( $from, $to ) {
      return $this->fs()->move( $from, $to );
    }

    function delete( $path ) {
      return $this->fs()->delete( $path );
    }

    function exists( $path ) {
      return $this->fs()->exists( $path );
    }

    function size( $path ) {
      return $this->fs()->size( $path );
    }

    function filename($url) {
      return basename(parse_url($url, PHP_URL_PATH));
    }

    function download_url($url, $timeout = 300) {

      $filename = $this->filename($url);

      if ( ! function_exists( 'wp_tempnam' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
      }

      $temporary_filepath = wp_tempnam( $filename );
      if (!$temporary_filepath) return new WP_Error('http_no_file', 'Could not create temporary file');

      $response = wp_remote_get($url,
        [ 'timeout'  => $timeout, 'stream'   => true, 'filename' => $temporary_filepath ]
      );

      if ( is_wp_error( $response ) ) {
        $this->delete( $temporary_filepath );
        return $response;
      }

      $response_code = wp_remote_retrieve_response_code($response);
      if ( 200 != $response_code ) {
        return new WP_Error('http_404', trim(wp_remote_retrieve_response_message($response)));
      }

      return $temporary_filepath;
    }

    /**
     * Download a zip file from a URL and extract to a temporary folder
     * The temporary folder must be deleted afterwards
     * @return string|WP_Error Path to extracted folder, or error
     */
    function download_url_and_unzip( $url ) {

      $temporary_filepath = $this->download_url($url);

      if (is_wp_error($temporary_filepath)) return $temporary_filepath;

      $filename = $this->filename($url);
      $temporary_folder = dirname($temporary_filepath).'/'.$filename.'-'.uniqid();

      $result = unzip_file($temporary_filepath, $temporary_folder);

      $this->delete($temporary_filepath);

      if (is_wp_error($result)) return $result;

      /**
       * Get file list: $this->dirlist($temporary_folder)
       * Remove folder when finished: $this->rmdir($temporary_folder, true);
       */
      return $temporary_folder;
    }

    /**
     * Return an instance of WP_Filesystem
     * @see wp-admin/includes/class-wp-filesystem-direct.php
     */
    function fs() {

      global $wp_filesystem;

      if ($wp_filesystem && $wp_filesystem->method==='direct') return $wp_filesystem;

      require_once ABSPATH . '/wp-admin/includes/file.php';

      $context = apply_filters( 'request_filesystem_credentials_context', false );

      add_filter( 'filesystem_method', [$this, 'filesystem_method']);
      add_filter( 'request_filesystem_credentials', [$this, 'request_filesystem_credentials']);

      $creds = request_filesystem_credentials( site_url(), '', true, $context, null );

      WP_Filesystem( $creds, $context );

      remove_filter( 'filesystem_method', [$this, 'filesystem_method']);
      remove_filter( 'request_filesystem_credentials', [$this, 'request_filesystem_credentials']);

      // Set the permission constants if not already set.
      if (!defined('FS_CHMOD_DIR')) define('FS_CHMOD_DIR', 0755);
      if (!defined('FS_CHMOD_FILE')) define('FS_CHMOD_FILE', 0644);

      return $wp_filesystem;
    }

    function filesystem_method() {
      return 'direct';
    }

    function request_filesystem_credentials() {
      return true;
    }
  };
};

// Global shortcut
if ( ! function_exists( 'tangible_filesystem' ) ) :
function tangible_filesystem($config) {
  return tangible()->filesystem($config);
}
endif;
