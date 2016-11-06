import os
from src import app
from src.redisClient import RedisClient

from flask.templating import render_template
from flask import request

'''
View for all service end points.

@author: shivam.maharshi
'''

@app.route('/')
@app.route('/index')
def index():
    return render_template('index.html', message='The caching service is up and running!')

@app.route('/cacheService/<path:pageUrl>', methods=['PUT'])
def cache(pageUrl=None):
    try:
        lineSep = os.linesep
        data = ''.join(request.data.decode('utf-8')).split(lineSep + lineSep)
        lastModified = fetchHeaderValue(data[0], "Last-Modified")
        pageContent = ''
        i = 1;
        while i < len(data):
            pageContent += data[i] + '\n'
            i = i+1

        RedisClient.set(pageUrl.strip() + lastModified, pageContent)
        return "Successfully saved!", 200;
    except Exception:
        return "Request unsuccessful!", 500;

def fetchHeaderValue(data, header) :
    res = ''
    data = data.split('\n')
    readingValue = False
    for d in data:
        if (d.startswith(header)):
            for c in d:
                if (not readingValue and c == ':'):
                    readingValue = True
                elif (readingValue):
                    res += c
        else:
            continue
    return res.strip()
