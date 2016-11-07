import os
from hashlib import md5

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

@app.route('/cacheService/<path:pageUrl>', methods=['GET'])
def get(pageUrl=None):
    try:
        hash = md5(pageUrl.strip().encode('utf-8'))
        return RedisClient.get(hash.hexdigest()), 200
    except Exception:
        return "Request unsuccessful!", 500;

@app.route('/cacheService/<path:pageUrl>', methods=['PUT'])
def save(pageUrl=None):
    try:
        lineSep = '\r\n'
        req = request.environ.get('wsgi.input').readlines()
        reqData = ''
        for rd in req:
            reqData += rd
        reqData = reqData.decode('utf-8')
        reqDataSeg = reqData.split(lineSep + lineSep)
        reqBody = ''
        i = 2;
        while i < len(reqDataSeg):
            reqBody += reqDataSeg[i] + '\n'
            i = i+1

        key = pageUrl.strip() + fetchHeaderValue(reqDataSeg[1], "Last-Modified")
        hash = md5(key.encode('utf-8'))
        #import pdb; pdb.set_trace()
        if not RedisClient.exists(hash.hexdigest()):
            # Asynchronously persist data in file.
            worker = PersistenceWorker(ARCHIVE_FILE, reqBody)
            worker.start()
            RedisClient.set(hash.hexdigest(), reqBody)
        else:
            print("Page already exists!")
        return "Successfully saved!", 200
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
