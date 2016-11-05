/**
* Thin client for Redis operations.
*
* @author: shivam.maharshi
*/

<?php

require "predis/autoload.php";

include '/var/www/html/apache-log4php-2.3.0/src/main/php/Logger.php';

Predis\Autoloader::register();

class RedisClient {

  private $host;
  private $port;
  private $redis;
  private $isAvailable;

  function __construct($memcacheHost, $memcachePort) {
    $this->host = $memcacheHost;
    $this->port = $memcachePort;
  }

  function __destruct() {
    unset($this->port, $this->host, $this->memcache, $this->isAvailable);
  }

  function connect() {
    $log = Logger::getLogger("myLogger");
    try {
        $this->redis = new Predis\Client(array("schema" => "tcp", "host" => $this->host, "port" => $this->port));
        $this->isAvailable = true;
    } catch (Exception $e) {
        $log->error("Error while connecting: ".$e->getMessage());
        $this->isAvailable = false;
    }
    return $this->isAvailable;
  }

  function add($key, $data) {
    $log = Logger::getLogger("myLogger");
    if($this->isAvailable) {
      $log->debug("Adding key: ".$key);
      $exists = $this->redis->set($key, $data);
      if($exists) {
        $log->info("Key adding success: ".$key);
      } else {
        $log->info("Key already exists: ".$key);
      }
    } else {
      $log->error("Can't connect to Redis. Make sure it is up and running!");
    }
    return $exists;
  }

  function get($key) {
    $log = Logger::getLogger("myLogger");
    if($this->isAvailable) {
      $log->info("Getting key: ".$key);
      return $this->redis->get($key);
    } else {
      $log->error("Can't connect to Redis. Make sure it is up and running!");
    }
  }

  function close() {
    $this->redis->disconnect();
  }

}

?>
