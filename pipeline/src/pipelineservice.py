import sys
import os
from Logger import Logger
from Configuration import Configuration  
from CloudUploader import CloudUploader
from FileSender import FileSender
from MessagesRepository import MessagesRepository
from MessagingService import MessagingService

def main():
    logger = Logger().getLogger()
    configuration = Configuration("pipeline.conf")
    cloud_config = configuration.get_cloud_config()
    msg_broker_config = configuration.get_msg_broker_config()
    db_config = configuration.get_db_config()
    repository = MessagesRepository(db_config)
    cloudUploader = CloudUploader(cloud_config, logger)
    fileSender = FileSender(cloudUploader, repository, logger)
    fileSender.sendPendingFiles()
    messagingService = MessagingService(msg_broker_config, fileSender, logger)
    messagingService.start_consuming()

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        logger = Logger().getLogger()
        logger.info("Interrupted")
        try:
            sys.exit(0)
        except SystemExit:
            os._exit(0)