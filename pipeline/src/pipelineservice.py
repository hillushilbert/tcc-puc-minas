import boto3
import configparser
import pika
import sys
import os
import logging
from bson.objectid import ObjectId
import pymongo 
from datetime import datetime
import time
import random

g_collection_name = ''
RETRY_DELAY = 3
LOCAL_DIR = '.'

def getAwsParams():
    parser = configparser.ConfigParser()
    parser.read("./pipeline.conf")

    params = {
        "access_key": parser.get("aws_boto_credentials", "access_key"),
        "secret_key": parser.get("aws_boto_credentials", "secret_key"),
        "bucket_name": parser.get("aws_boto_credentials", "bucket_name")
    }

    return params

def getRabbitParams(): 
    parser = configparser.ConfigParser()
    parser.read("./pipeline.conf")

    params = {
        "server": parser.get("message_broker", "server"),
        "vhost": parser.get("message_broker", "vhost"),
        "queue": parser.get("message_broker", "queue"),
    }

    return params

def getDbParams():
    parser = configparser.ConfigParser()
    parser.read("./pipeline.conf")

    params = {
        "connection_string": parser.get("database", "connection_string"),
        "database_name": parser.get("database", "database_name"),
        "collection_name": parser.get("database", "collection_name")
    }

    return params

def getDbConnection(db_params):
    connection_string = db_params['connection_string']
    client = pymongo.MongoClient(connection_string)
    dbname = client[db_params['database_name']]
    return dbname

def getMessageChannel(rabbitmq_server, vhost):
    credentials_rabbit = pika.PlainCredentials('app_pedido', 'app_pedido')
    connection = pika.BlockingConnection(pika.ConnectionParameters(host = rabbitmq_server, virtual_host = vhost, credentials = credentials_rabbit))
    channel = connection.channel()
    return channel

def startService(message_broker_params):
    channel = getMessageChannel(message_broker_params['server'], message_broker_params['vhost'])
    channel.queue_declare(message_broker_params['queue'], durable=True)

    channel.basic_consume(message_broker_params['queue'], on_message_callback=handleNewMessage, auto_ack = True)
    logging.info('Service started')

    logging.info("Waiting for messages. To exit press Ctrl-C")

    channel.start_consuming()

def saveFileLocal(filename, content):
    f = open(filename, "w")
    f.write(content)
    f.close()

def getCollectionName():
    global g_collection_name
    return g_collection_name

def setCollectionName(collection_name):
    global g_collection_name
    g_collection_name = collection_name

def handleNewMessage(ch, method, properties, message_body):
    message = str(message_body, 'UTF-8')
    collection_name = getCollectionName()
    logging.info("Received %r" %message)
    current_time = f'{datetime.now().strftime("%H%M%S")}-{random.randrange(1,1000)}'
    local_filename = "pedidorecebido-" + current_time + ".json"
    logging.info(f'Filename: {local_filename}')
    local_dir = LOCAL_DIR
    db_record = {
        'message': message,
        'name': local_filename
    }
    saved_item = collection_name.insert_one(db_record)
    id = saved_item.inserted_id

    saveFileLocal(local_filename, message)
    aws_parameters = getAwsParams();
    uploadS3Retry(aws_parameters, local_dir, local_filename, collection_name, id)

def uploadS3(aws_parameters, local_dir, local_filename):
    s3 = boto3.client('s3', aws_access_key_id=aws_parameters['access_key'], aws_secret_access_key=aws_parameters['secret_key'])

    fullpath_filename = f'{local_dir}/{local_filename}'
    s3_file = local_filename

    s3.upload_file(fullpath_filename, aws_parameters['bucket_name'], s3_file)
    logging.info(f"Upload of file {fullpath_filename} to S3 bucket {aws_parameters['bucket_name']} successful!")


def uploadS3Retry(aws_parameters, local_dir, local_filename, collection_name, id):
    upload_succesful = False
    
    while (not upload_succesful):
        try:
            uploadS3(aws_parameters, local_dir, local_filename)
            upload_succesful = True
            collection_name.delete_one({'_id': ObjectId(id)})
        except:
            logging.info(f'Failure uploading file {local_filename} !')
            time.sleep(RETRY_DELAY)

def sendPendingFiles():
    collection_name = getCollectionName()
    pending_files = collection_name.count_documents({})
    if (pending_files > 0):
        logging.info(f'Found {pending_files} pending files!')
    else:
        logging.info(f'Found no pending files!')

    list = collection_name.find()
    for record in list:
        logging.info(record['name'])
        local_dir = LOCAL_DIR
        local_filename = record['name']
        id = record['_id']
        saveFileLocal(local_filename, record['message'])
        aws_parameters = getAwsParams()
        logging.info(f'Sending file {local_filename}...')
        uploadS3Retry(aws_parameters, local_dir, local_filename, collection_name, id)

def main():
    logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s",
    handlers=[
        logging.FileHandler("info.log"),
        logging.StreamHandler(sys.stdout)
    ])
    logging.info('Connecting database...')
    db_params = getDbParams()
    dbname = getDbConnection(db_params)
    setCollectionName(dbname[db_params['collection_name']])

    sendPendingFiles()

    message_broker_params = getRabbitParams()
    startService(message_broker_params)

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        logging.info("Interrupted")
        try:
            sys.exit(0)
        except SystemExit:
            os._exit(0)