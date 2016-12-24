from src import app
from gevent.wsgi import WSGIServer

http_server = WSGIServer(('127.0.0.1', 8080), app)
http_server.serve_forever()
