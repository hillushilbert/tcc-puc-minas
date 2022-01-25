import pika
local_filename = "pedidoenviar.json"
f = open(local_filename, "r")
pedido_enviar = f.read()
credentials_rabbit = pika.PlainCredentials('app_pedido', 'app_pedido')
connection = pika.BlockingConnection(pika.ConnectionParameters('rabbit', virtual_host = "boaentrega.pedidos",credentials = credentials_rabbit))
channel = connection.channel()
channel.queue_declare(queue="boaentrega.pedidos.pipeline", durable=True)

channel.basic_publish(exchange="novo_pedido", routing_key="boaentrega.pedidos.roteamento", body=pedido_enviar)
print(f"[x] Sent {local_filename}")

connection.close()
