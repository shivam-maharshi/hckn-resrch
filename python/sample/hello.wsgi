import sys
sys.path.insert(0, '/var/www/html/flask_dev')

from hello import app as application

sys.stdout = sys.stderr
