Para ativar o venv:
 source /home/andrem/projetos/tcc/env/bin/activate

Antes  de rodar deeve-se levantar o mongo
cd pipeline
docker-compose up

Para rodar o pipeline

 docker build -t pipelineservice .

 docker run --rm --net=pucminas --name=pipeline pipelineservice

Usando docker-compose:
 docker build -t andremoreirafocus/pipeline_pedidos:latest .
 docker-compose up

 Para ver os logs:
 docker logs pipeline

 O arquivo pipeline.conf contem as configurações do pipeline

Para testar, basta executar o comando abaixo:
 python3 producertcc.py

Uma mensagem é enviada ao rabbitmq na fila de interesse do pipeline.

IMPORTANTE: o producertcc.py usa o arquivo pedidoenviar.json para publicar a mensagem no rabbit

Este serviço se conecta ao message broker e se inscreve em uma fila.

Ao receber uma mensagem, que contem um pedido, ele:
  - gera o nome do arquivo a ser salvo
  - salva no banco de dados o nome do arquivo a ser salvo e o conteúdo da mensagem recebida
  - salva o arquivo localmente com o nome estipulado e o conteúdo da mensagem recebida
  - tenta fazer o upload do arquivo para o AWS S3
  - caso consiga fazer o upload, remove o registro do banco de dados e fica liberado para processar mais mensagens
  - caso falhe no upload, fica tentando fazer o upload indefinidamente até conseguir
  - ao conseguir, remove o registro correspondente do banco de dados
  - se o serviço parar, o registro permanece no banco de dados

Em função disto, quando o serviço inicia, verifica se tem registros no banco de dados e tenta efetuar a transferência.

Caso falhe, tentará indefinidamente até conseguir e passar para o próximo arquivo pendente, removendo o registro do banco de dados.

Encerrado o envio de arquivos pendentes a comunicação com o message broker é iniciada.

