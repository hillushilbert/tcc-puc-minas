class FileSender:
    import time
    import os
    from datetime import datetime
    import random

    RETRY_DELAY = 3
    LOCAL_DIR = 'tmp'
    
    def __init__(self, cloudUploader, repository, logger):
        self.cloudUploader = cloudUploader
        self.repository = repository
        self.logger = logger
        self.checkAndCreateLocalDir(self.LOCAL_DIR)

    def send(self, message):
        filename = self.genFileName()
        pending_file_record = {
            'message': message,
            'name': filename
        }
        saved_id = self.repository.save(pending_file_record)
        self.logger.info(f'Filename: {filename} saved at database with id {saved_id}')
        self.saveFileLocal(filename, message)
        self.reliableUpload(filename, saved_id)
        self.removeFileLocal(filename)

    def sendPendingFiles(self):
        pending_files = self.repository.count()
        if (pending_files > 0):
            self.logger.info(f'Found {pending_files} pending files!')
        else:
            self.logger.info(f'Found no pending files!')

        list = self.repository.findAll()
        for record in list:
            filename = record['name']
            message = record['message']
            id = record['_id']
            self.saveFileLocal(filename, message)
            self.reliableUpload(filename, id)
            self.removeFileLocal(filename)

    def reliableUpload(self, filename, id):
        self.logger.info(f'Sending file {filename}...')
        upload_succesful = False       
        while (not upload_succesful):
            try:
                self.uploadFileToCloud(filename)
                upload_succesful = True
                self.repository.deleteById(id)
            except Exception as e:
                if hasattr(e, 'message'):
                    message = e.message
                else:
                    message = e
                self.logger.info(f'{message}!')
                self.logger.info(f'Failure uploading file {filename}!')
                self.time.sleep(self.RETRY_DELAY)

    def uploadFileToCloud(self, local_filename):
        local_dir = self.LOCAL_DIR
        self.cloudUploader.upload(local_dir, local_filename)

    def saveFileLocal(self, filename, content):
        local_filename = f'{self.LOCAL_DIR}/{filename}'
        f = open(local_filename, "w")
        f.write(content)
        f.close()

    def removeFileLocal(self, filename):
        local_filename = f'{self.LOCAL_DIR}/{filename}'
        self.os.remove(local_filename)

    def checkAndCreateLocalDir(self, dir):
        if not self.os.path.isdir(dir):
            try:
                self.os.mkdir(dir)
            except:
                self.logger.error(f'Impossible to create folder {dir}')

    def genFileName(self):
        current_time = f'{self.datetime.now().strftime("%H%M%S")}-{self.random.randrange(1,1000)}'
        return "pedidorecebido-" + current_time + ".json"
                
