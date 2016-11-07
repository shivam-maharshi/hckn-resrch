import threading

class PersistenceWorker (threading.Thread):

    def __init__(self, filepath, data):
        super(PersistenceWorker, self).__init__()
        self.filepath = filepath
        self.data = data

    def run(self):
        with open(self.filepath, "a") as f:
            f.write(self.data.encode('utf-8'))
