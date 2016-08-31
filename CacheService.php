<?php

error_reporting(E_ALL);
#include 'MemcacheClient.php';
include 'RedisClient.php';
#include '/var/www/html/apache-log4php-2.3.0/src/main/php/Logger.php';

define('HOST', '127.0.0.1');
#define('PORT', '11211');
define('PORT', '6379');
define('ARCHIVE_DIR', '/var/www/html/archive/');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$fullURLPath = $_SERVER['REQUEST_URI'];
$segments = explode('http://', $_SERVER['REQUEST_URI']);
$cacheURL = "http://".$segments[1];
$cacheURL = md5($cacheURL);

Logger::configure('config.xml');
$logger = Logger::getLogger("myLogger");

$cache = new RedisClient(HOST, PORT);
$cacheAvailable = $cache->connect();

if($cacheAvailable) {
  $logger->info("Successfully connected to cache server: ".HOST.":".PORT);
} else {
  $logger->error("Can't connect to cache. Make sure it is up and running!");
}

$logger->debug("Method: ".$httpMethod);

if($httpMethod == 'PUT') {
    $logger->info("Writing cached response for URL: ".$cacheURL);
    $handle = fopen('php://input', 'rb');
    $rawPutData = '';
    $is_response = false;
    if($handle) {
      while(($buffer = fgets($handle, 4096)) !== false) {
        if($is_response) {
          $rawPutData .= $buffer;
        } else {
          $buffer = trim($buffer);
          if($buffer == '') {
            $is_response = true;
          }
        }
      }
      if(!feof($handle)) {
        $logger->error("Error: unexpected fgets() fail.");
      }
    }

  if($cacheAvailable) {
    $logger->debug("Writing PUT request body to cache: ".$rawPutData);
    $newKeyAdded = $cache->add($cacheURL, $rawPutData);

    if($newKeyAdded) {
      $logger->debug("URL adding success: ".$cacheURL);    
    } else {
      $logger->info("URL already exists: ".$cacheURL);
    }
  } else {
    $logger->error("Can't connect to cache. Make sure it is up and running!");
  }

  # Write response to a file.
  $file = ARCHIVE_DIR.$cacheURL.".txt";
  if(file_exists($file)) {
    $logger->info("Response cache file already exists! : ".$file);
  } else {
    $logger->info("Writing file: ".$file);
    $fileWriteStatus = file_put_contents($file, $rawPutData);
    if($fileWriteStatus) {
      $logger->info("File written successfully: ".$file);
    } else {
      $logger->error("File writting failed: ".$file);
    }
  }
} elseif($httpMethod == 'GET') {
    $logger->info("Fetching cached response for URL from cache: ".$cacheURL);
    if($cacheAvailable) {
      $logger->debug("Response for URL: ".$cache->get($cacheURL));
      print_r($cache->get($cacheURL));
    } else {
      $logger->error("Can't connect to cache. Make sure it is up and running!");
    }
} else {
    $logger->error("Unsupported HTTP Method: ".$httpMethod);
}

$cache->close();
$logger->info("Closed client connection");
unset($fullURLPath, $segments, $cacheURL, $cacheAvailable, $httpMethod, $cache);
?>
