class MessagingService:
    import pika

    def __init__(self, message_broker_params, fileSender, logger) :
        self.logger = logger
        self.fileSender = fileSender
        self.server = message_broker_params['server']
        self.vhost = message_broker_params['vhost']
        self.queue = message_broker_params['queue']
        self.user = message_broker_params['user']
        self.password = message_broker_params['password']
        self.channel = self.getMessageChannel()
        self.channel.queue_declare(self.queue, durable=True)
        self.channel.basic_consume(self.queue, on_message_callback=self.handleNewMessage, auto_ack = True)
        self.logger.info('Service started')
        self.logger.info("Waiting for messages. To exit press Ctrl-C")

    def getMessageChannel(self):
        credentials_rabbit = self.pika.PlainCredentials(username = self.user, password = self.password)
        connection = self.pika.BlockingConnection(self.pika.ConnectionParameters(host = self.server, virtual_host = self.vhost , credentials = credentials_rabbit))
        channel = connection.channel()
        return channel

    def start_consuming(self):
        self.channel.start_consuming()

    def handleNewMessage(self, ch, method, properties, message_body):
        content = str(message_body, 'UTF-8')
        self.logger.info("Received %r" %content)
        self.fileSender.send(content)



