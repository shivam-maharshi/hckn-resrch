from flask import Flask
app = Flask(__name__)

@app.route('/')
@app.route('/cacheService/<path:pageUrl>')
def hello_world():
    return 'HelloWorld!'

if __name__ =='__main__':
    app.run()
