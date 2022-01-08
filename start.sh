cd apigateway
docker-compose build kong
docker-compose up -d db
sleep 2m
#docker-compose run --rm kong kong migrations bootstrap
#docker-compose run --rm kong kong migrations up
docker-compose up -d kong
docker-compose ps
curl -s http://localhost:8001 | jq .plugins.available_on_server.oidc
docker-compose up -d konga
sleep 2m
cd ../identity
docker-compose up -d
docker-compose ps
cd ../eventbus
docker-compose up -d
docker-compose ps
cd ../pedidos
docker-compose up -d
docker-compose ps
cd ../despacho
docker-compose up -d
docker-compose ps
cd ../sge
docker-compose up -d
docker-compose ps
cd ../infoCadastrais
docker-compose up -d
docker-compose ps
cd ../controleAcesso
docker-compose up -d
docker-compose ps