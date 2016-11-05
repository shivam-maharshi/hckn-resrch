from src import app
from flask.templating import render_template

@app.route('/')
@app.route('/index')
def index():
    return render_template('index.html', message='The caching service is up!')

@app.route('/cacheService/<path:pageUrl>', methods=['PUT'])
def cache(pageUrl):
    
    return "Successfully saved!", 200;