#import logging
#logging.basicConfig(filename='/var/www/html/debug.log', level=logging.DEBUG)
import os
import os.path
from hashlib import md5
from gevent import monkey
monkey.patch_all()
from gevent.pywsgi import WSGIServer

def hello(env, start_response):
    fp = '/var/www/html/archive/' + md5(env['PATH_INFO'][14:]).hexdigest()
    if not os.path.exists(fp):
        d = unicode(env['wsgi.input'].read(), errors='ignore')
        with open(fp, "a") as f:
            f.write(d)
    start_response('200 OK', [('Content-Type', 'text/html')])
    return 'OK\n'

server = WSGIServer(('127.0.0.1',8080), hello)

server.serve_forever()
