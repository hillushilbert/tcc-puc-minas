class CloudUploader:
    from botocore.client import Config
    import boto3

    def __init__(self, aws_config, logger):
        self.access_key = aws_config['access_key']
        self.secret_key = aws_config['secret_key']
        self.bucket_name = aws_config['folder_name']      
        self.boto3_config = self.Config(connect_timeout=5, retries={'max_attempts': 0})
        self.logger = logger;

    def upload(self, local_dir, local_filename):
        s3 = self.boto3.client('s3', aws_access_key_id=self.access_key, aws_secret_access_key=self.secret_key, config=self.boto3_config)
        fullpath_filename = f'{local_dir}/{local_filename}'
        s3_file = local_filename
        s3.upload_file(fullpath_filename, self.bucket_name, s3_file)
        self.logger.info(f"Upload of file {fullpath_filename} to S3 bucket {self.bucket_name} successful!")

