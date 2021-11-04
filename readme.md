# Projeto TCC Arquitetura Distribuida Puc Minas

 ## Básico do docker-compose

 - **docker-compose build** - Realiza o build de containers que devem ser compilados
 - **docker-compose up -d** - Realiza o processo de subir os containers listados no arquivo docker-compose.yml sem travar o terminal
 - **docker-compose down** - Realiza o termino de todos os containers, volumes e redes criados no up -d
 - **docker-compose exec nomeservico command** - Você pode executar um comando direto no container ou entrar nele, por exemplo: docker-compose exec postgres bash, para sair só dar um exit
 - **docker-compose logs / docker-compose logs nomservico** - lista o log de sistema do container sem precisar entrar nele 
  - **docker-compose ps** - lista os status dos containers

  - **docker-compose restat nomeservico** - reinica um container pelo nome do serviço. 

 ## Criando a rede externa para os container

        docker network create pucminas


 ##  Subir o ApiGateway

        entrar no diretorio apigateway

        executar: docker-compose up -d

        observar se o serviço subiu por: docker-compose logs ou docker-compose logs nomeservico

 - Acessando o Konga

        A porta do Konga é a 1337
        localhost:1337 
 ## Subir o RabbitMq

        Entrar no diretório eventbus e executar:
        docker-compose up -d

 - Acessando o RabbitMQ Management

        A porta do Rabbitmq é a 5672 e o management na porta 15672, com usuário e senha padrões : guest e guest


 ## Acessando o Konga

       A partir da URL http://localhost:1337 com usuario admin e senha admin123

## Acessando o pgadmin4

       A partir da URL http://localhost:15432 com usuario king@kong.com e senha kong

## Links 

 - **Kong e Konga** (https://www.youtube.com/watch?v=_2GRXgYswhI)



 # Escopo Serviços 

       1 - Implementar um serviço de geração de OS que:
 - comunicação com o frontend
 - recebe um pedido de geração de OS a partir do fronted (através do api gateway)
  	
	POST 
	pedido: 
	{
		cliente: João
		endereço cliente:  Rua das Marrecas, 34
		endereço coleta: Rua dos Pepinos, 200
		produto: "guitarra",
		fornecedor: Americanas,
		preço: 2500
	}

	retornar um id do pedido

	GET /pedido

	{
		dados do pedido
	}

 - despacho da OS para transporte
 - envio: pedido será enviado para a fila do serviço de despacho de encomenda	

2 - Api gateway 
	- cadastrar o serviço (rota, url)
	- autenticação do usuário via jwt
	- no postman conectar usando jwt

3 - serviço de despacho de encomenda
- pega o pedido na fila do rabbit
- despacha a encomenda
- envia o status de despacho feito para uma fila no rabbit

4 - serviço de envio de notificação para o usuário final com o CT-e ou link para acompanhamento do andamento do transporte
	- recebe do rabbit
	- envia e-mail

