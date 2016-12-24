import redis;

'''
Thin RedisClient for operations on Redis.

@author: shivam.maharshi
'''
class RedisClient(object):

    rc = redis.StrictRedis(host='127.0.0.1', port=6379, db=0);

    @staticmethod
    def set(key, data):
        print ("SET Key: " + key)
        return RedisClient.rc.setnx(key, data)

    @staticmethod
    def get(key):
        print ("GET Key: " + key)
        return RedisClient.rc.get(key)

    @staticmethod
    def exists(key):
        return RedisClient.rc.exists(key)
