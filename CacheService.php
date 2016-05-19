<?php

error_reporting(E_ALL);
include 'MemcacheClient.php';
#include '/var/www/html/apache-log4php-2.3.0/src/main/php/Logger.php';

define('MEMCACHED_HOST', '127.0.0.1');
define('MEMCACHED_PORT', '11211');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$fullURLPath = $_SERVER['REQUEST_URI'];
$segments = explode('http://', $_SERVER['REQUEST_URI']);
$cacheURL = "http://".$segments[1];

Logger::configure('config.xml');
$logger = Logger::getLogger("myLogger");

// Create connection
$memcacheClient = new MemcacheClient(MEMCACHED_HOST, MEMCACHED_PORT);
$cacheAvailable = $memcacheClient->connect();

if($cacheAvailable) {
  $logger->info("Successfully connected to Memcache server: ".MEMCACHED_HOST.":".MEMCACHED_PORT);
} else {
  $logger->error("Can't connect to Memcache. Make sure it is up and running!");
}

$logger->info("Method: ".$httpMethod);

if($httpMethod == 'PUT') {
    $logger->info("Writing cached response for URL: ".$cacheURL);
    $handle = fopen('php://input', 'rb');
    $rawPutData = '';
    while($chunk = fread($handle, 1024)) {
      $rawPutData .= $chunk;
    }
   if($cacheAvailable) {
    $logger->info("Writing PUT request body to Memcache: ".$rawPutData);
    $newKeyAdded = $memcacheClient->add($cacheURL, $rawPutData);
    if($newKeyAdded) {
      $logger->error("URL adding success: ".$cacheURL);    
    } else {
      $logger->error("URL already exists: ".$cacheURL);
    }
   } else {
    $logger->error("Can't connect to Memcache. Make sure it is up and running!");
   }
} elseif($httpMethod == 'GET') {
    $logger->info("Fetching cached response for URL from Memcache: ".$cacheURL);
    if($cacheAvailable) {
      $logger->error("Response for URL: ".$memcacheClient->get($cacheURL));
      print_r("Response for URL: ".$memcacheClient->get($cacheURL));
    } else {
      $logger->error("Can't connect to Memcache. Make sure it is up and running!");
    }
} else {
    $logger->error("Unsupported HTTP Method: ".$httpMethod);
}

$memcacheClient->close();
$logger->info("Closed client connection");
unset($fullURLPath, $segments, $cacheURL, $cacheAvailable, $httpMethod, $memcacheClient);
?>
