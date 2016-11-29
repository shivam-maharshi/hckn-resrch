# CachingService
A Web Service that provides HTTP PUT request body caching & persistence. Currently implemented in two languages:<br><br>
1. _**PHP**_ - which uses Apache Web Server or NGNIX to run.<br>
2. _**Python**_ - which starts a light weight Flask server.

## Supported Services - Caching & Persisted

The backend can be configured to use different caching and persistence services.

### The service currently supports storing data in:
1. [Memcached](https://memcached.org/)
2. [Redis](http://redis.io/)
3. Files - Asnychronously for high performance using PThreads in PHP & native threading library in Python.

## Usage

### To use this caching service use the format given below:

1. The HTTP PUT request URL format is: http://{host}:{port}/cacheService.php/{KEY_TO_BE_CACHED_OR_PERSISTED}
2. Given below is the sample request body for storing a Web Page response into the caching service. 

HTTP PUT Request Body:

HTTP/1.1 200 OK<br>
Date: Tue, 30 Aug 2016 15:47:25 GMT<br>
Server: Apache/2.2.15 (CentOS)<br>
X-Powered-By: PHP/5.3.3<br>
X-Content-Type-Options: nosniff<br>
Content-language: el<br>
X-UA-Compatible: IE=Edge<br>
Vary: Accept-Encoding,Cookie<br>
Expires: Thu, 01 Jan 1970 00:00:00 GMT<br>
Cache-Control: private, must-revalidate, max-age=0<br>
Last-Modified: Mon, 21 Mar 2016 01:34:14 GMT<br>
Connection: close<br>
Transfer-Encoding: chunked<br>
Content-Type: text/html; charset=UTF-8<br>

{HTTP PAGE DATA}
