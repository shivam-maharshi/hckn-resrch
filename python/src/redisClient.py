import redis;

'''
Thin RedisClient for operations on Redis.

@author: shivam.maharshi
'''
class RedisClient(object):

    rc = redis.StrictRedis(host='127.0.0.1', port=6379, db=0);

    @staticmethod
    def set(key, data):
        return RedisClient.rc.setnx(key, data)

    @staticmethod
    def get(key):
        return RedisClient.rc.get(key)
