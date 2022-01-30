
class Configuration:
    import configparser
    def __init__(self, config_file_name):
        self.config_file_name = config_file_name

    def get_cloud_config(self):
        parser = self.configparser.ConfigParser()
        parser.read(self.config_file_name)

        self.cloud_config = {
            "access_key": parser.get("cloud_credentials", "access_key"),
            "secret_key": parser.get("cloud_credentials", "secret_key"),
            "folder_name": parser.get("cloud_credentials", "folder_name")
        }

        return self.cloud_config
        
    def get_msg_broker_config(self):
        parser = self.configparser.ConfigParser()
        parser.read(self.config_file_name)

        self.msg_broker_config = {
            "server": parser.get("message_broker", "server"),
            "vhost": parser.get("message_broker", "vhost"),
            "queue": parser.get("message_broker", "queue"),
            "user": parser.get("message_broker", "user"),
            "password": parser.get("message_broker", "password"),
        }

        return self.msg_broker_config

    def get_db_config(self):
        parser = self.configparser.ConfigParser()
        parser.read(self.config_file_name)

        self.db_config = {
            "connection_string": parser.get("database", "connection_string"),
            "database_name": parser.get("database", "database_name"),
            "collection_name": parser.get("database", "collection_name")
        }

        return self.db_config
