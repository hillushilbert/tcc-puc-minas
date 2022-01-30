class MessagesRepository:
    import pymongo 
    from bson.objectid import ObjectId 

    def __init__(self, db_config):
        self.connection_string = db_config['connection_string']
        self.database_name = db_config['database_name']
        self.collection_name = db_config['collection_name']
        self.client = self.pymongo.MongoClient(self.connection_string)
        self.db = self.client[self.database_name]
        self.collection =  self.db[self.collection_name]

    def findAll(self):
        return self.collection.find()

    def save(self, record):
        saved_item = self.collection.insert_one(record)
        id = saved_item.inserted_id
        return id

    def deleteById(self, id):
        self.collection.delete_one({'_id': self.ObjectId(id)})

    def count(self):
        return self.collection.count_documents({})

