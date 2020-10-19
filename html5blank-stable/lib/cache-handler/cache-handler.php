<?php
/**
 * Cache helper. Saves cached data in files.
 */
class CacheHandler {
  // Path to the cache folder
  private $cache_folder;

  function __construct() {
    $this->cache_folder = dirname(__FILE__) . '/cache/';
  }

  // Checks whether the page has been cached or not. Default to 1 hour cache.
  public function is_cached($file, $cache_expires = 3600) {
    $cachefile = $this->cache_folder . $file;
    $cachefile_created = (file_exists($cachefile)) ? @filemtime($cachefile) : 0;
    return ((time() - $cache_expires) < $cachefile_created);
  }

  // Reads from a cached file
  public function read_cache($file) {
    $cachefile = $this->cache_folder . $file;
    return file_get_contents($cachefile);
  }

  // Writes to a cached file
  public function write_cache($file, $content) {
    $cachefile = $this->cache_folder . $file;
    $fp = fopen($cachefile, 'w');

    if ($fp) {
      fwrite($fp, $content);
      fclose($fp);
    }
  }
}
