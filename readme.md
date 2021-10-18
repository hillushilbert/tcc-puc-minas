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

