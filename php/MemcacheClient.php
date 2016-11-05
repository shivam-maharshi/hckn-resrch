/**
* Thin client for Memcached operations.
*
* @author: shivam.maharshi
*/

<?php

include '/var/www/html/apache-log4php-2.3.0/src/main/php/Logger.php';

class MemcacheClient {

  private $host;
  private $port;
  private $memcache;
  private $isAvailable;

  function __construct($memcacheHost, $memcachePort) {
    $this->host = $memcacheHost;
    $this->port = $memcachePort;
  }

  function __destruct() {
    unset($this->port, $this->host, $this->memcache, $this->isAvailable); 
  }

  function connect() {
    $this->memcache = new Memcache;
    $this->isAvailable = $this->memcache->connect($this->host, $this->port);
    return $this->isAvailable;
  }

  function add($key, $data) {
    $log = Logger::getLogger("myLogger");
    if($this->isAvailable) {
      $log->info("Adding key: ".$key);
      $exists = $this->memcache->add($key, $data);
      if($exists) {
        $log->error("Key adding success: ".$key);
      } else {
        $log->error("Key already exists: ".$key);
      }
    } else {
      $log->error("Can't connect to Memcache. Make sure it is up and running!");
    }
    return $exists;
  }

  function get($key) {
    $log = Logger::getLogger("myLogger");
    if($this->isAvailable) {
      $log->error("Getting key: ".$key);
      return $this->memcache->get($key);
    } else {
      $log->error("Can't connect to Memcache. Make sure it is up and running!");
    }
  }

  function close() {
    $this->memcache->close();
  }

}

?>
