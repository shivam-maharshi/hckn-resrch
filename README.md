# CachingService
A Web Service that provides HTTP PUT request body caching & persistence. Currently implemented in two languages:<br>
1. PHP - which uses Apache Web Server or NGNIX to run.<br>
2. Python - which starts a light weight Flask server.

## Supported Services - Caching & Persisted

The backend can be configured to use different caching and persistence services.
### The service currently supports storing data in:
1. Memcached
2. Redis
3. Files - Asnychronously for high performance using PThreads in PHP & native threading library in Python.

## Usage

### To use this caching service use the format given below:

1. The HTTP PUT request URL format is: http://{host}:{port}/cacheService.php/{KEY_TO_BE_CACHED_OR_PERSISTED}
2. Given below is the sample request body for storing a Web Page response into the caching service. 

HTTP PUT Request Body:

HTTP/1.1 200 OK
Date: Tue, 30 Aug 2016 15:47:25 GMT
Server: Apache/2.2.15 (CentOS)
X-Powered-By: PHP/5.3.3
X-Content-Type-Options: nosniff
Content-language: el
X-UA-Compatible: IE=Edge
Vary: Accept-Encoding,Cookie
Expires: Thu, 01 Jan 1970 00:00:00 GMT
Cache-Control: private, must-revalidate, max-age=0
Last-Modified: Mon, 21 Mar 2016 01:34:14 GMT
Connection: close
Transfer-Encoding: chunked
Content-Type: text/html; charset=UTF-8

{HTTP PAGE DATA}
