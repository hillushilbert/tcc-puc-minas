https://newbedev.com/resources-scopes-permissions-and-policies-in-keycloak

https://medium.com/@harsh.manvar111/keycloak-authorization-service-rbac-1c3204a33a50

https://faun.pub/kong-jwt-scope-base-auth-with-keycloak-b9938a96d281


curl -s -X POST http://localhost:8001/services -d name=pgadmin -d url=http://pgadmin | python -mjson.tool

{"host":"pgadmin","id":"81d85ce2-341a-4a57-b084-b23be1c48ed6","protocol":"http","read_timeout":60000,"tls_verify_depth":null,"port":80,"updated_at":1639259303,"ca_certificates":null,"created_at":1639259303,"connect_timeout":60000,"write_timeout":60000,"name":"pgadmin","retries":5,"path":null,"tls_verify":null,"tags":null,"client_certificate":null}

curl -s -X POST http://localhost:8001/routes -d service.id=81d85ce2-341a-4a57-b084-b23be1c48ed6 -d paths[]=/pgadmin

secret id 6f5ce0ef-a227-421c-b290-a806f55c0115

curl -s -X POST http://localhost:8001/plugins \
  -d name=oidc \
  -d config.client_id=kong \
  -d config.client_secret=6f5ce0ef-a227-421c-b290-a806f55c0115 \
  -d config.bearer_only=yes \
  -d config.realm=experimental \
  -d config.introspection_endpoint=http://keycloak:8080/auth/realms/experimental/protocol/openid-connect/token/introspect \
  -d config.discovery=http://keycloak:8080/auth/realms/experimental/.well-known/openid-configuration
  

curl -s -X POST http://localhost:8001/plugins \
 -d name=oidc \
 -d config.client_id=kong-oidc \
 -d config.client_secret=29d98bf7-168c-4874-b8e9-9ba5e7382fa0 \
 -d config.discovery=https%3A%2F%2F<oidc_provider>%2F.well-known%2Fopenid-configuration
  
  ===================================================

  https://github.com/gbbirkisson/kong-plugin-jwt-keycloak


export CLIENT_ID=kong
export CLIENT_SECRET=6f5ce0ef-a227-421c-b290-a806f55c0115

export TOKENS=$(curl -s -X POST \
-H "Content-Type: application/x-www-form-urlencoded" \
-d "grant_type=client_credentials" \
-d "client_id=${CLIENT_ID}" \
-d "client_secret=${CLIENT_SECRET}" \
http://localhost:8180/auth/realms/experimental/protocol/openid-connect/token)

export ACCESS_TOKEN=$(echo ${TOKENS} | jq -r ".access_token")

curl -H "Authorization: Bearer ${ACCESS_TOKEN}" http://localhost:8000/pedidos/orders \
    --data "plugin=working"



============================================================================================

Recuperando token 

export RAWTKN=$(curl -s -X POST \
        -H "Content-Type: application/x-www-form-urlencoded" \
        -d "username=test" \
        -d "password=test123" \
        -d 'grant_type=password' \
        -d "client_id=app" \
        http://localhost:8180/auth/realms/experimental/protocol/openid-connect/token \
        |jq . )

echo $RAWTKN
{
  "access_token": "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJENkhLTHlubllGVkEtNGZKLWFLR3o1ai0xMHNFQ2NBZTA1UUp0Y05xdEN3In0.eyJqdGkiOiI1NmNkOGYyYy1iZGViLTQ5ODktYjJjNi0zMzRmZjQwOWQxYzIiLCJleHAiOjE1Njc3NDc0MDcsIm5iZiI6MCwiaWF0IjoxNTY3NzQ3MTA3LCJpc3MiOiJodHRwOi8vMTkyLjE2OC44OC4yMTo4MTgwL2F1dGgvcmVhbG1zL2V4cGVyaW1lbnRhbCIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNTg0OWM0NS05ZTIxLTRmOTQtYjZmNC1hMzkyMTMyNmRkNGIiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJteWFwcCIsImF1dGhfdGltZSI6MCwic2Vzc2lvbl9zdGF0ZSI6ImIxNGI2ODk0LTE1ZjQtNDE3Ni1iYjkwLWRiOThlYjg3OTRkNSIsImFjciI6IjEiLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoicHJvZmlsZSBlbWFpbCIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJuYW1lIjoiRGVtbyBVc2VyIiwicHJlZmVycmVkX3VzZXJuYW1lIjoiZGVtb3VzZXIiLCJnaXZlbl9uYW1lIjoiRGVtbyIsImZhbWlseV9uYW1lIjoiVXNlciIsImVtYWlsIjoidGVzdEB0ZXN0LmNvbSJ9.i0S_8Bf9TfVbHHTIVTIMM-q4K65jLhzuXnRfUvXdCti0LfxjEl_vrj9dzsigUhi-C5JKRGyZYi3ZZn6rlpgWD0uzVDcl6jMnpFW4lrJukrKHGUVd6_VYLPkdRFnylmsYfuvMT2DdHBVhpFOzhnr1zP9cGGdFozUzd90Drj_P6l1wjWg47Jwgo5WsJCnr1jzcPY784Ao2Lz2jFZwiBSqWW1Hwj2uSZRXRvjjPd0_LUhGqSi5LFjTFni3eTLXPBwrjSZq_JBlk1hMEoMfp7JKnB5tF4poGSO2tRTd-3j80BlY6jwAyTDWDDw0-fdp_UrhW_10VaxPXNyHc0AgGXDkvDA",
  "expires_in": 300,
  "refresh_expires_in": 1800,
  "refresh_token": "eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICIyZGZmMDI2MS01YzdjLTRmNGQtOTAxZS1lZjI3ZjM0YTNmNTUifQ.eyJqdGkiOiIyNjE2NDQyYi00ZTI5LTRmY2ItYTMzNi05ZTg5ZGZiNTUxNTgiLCJleHAiOjE1Njc3NDg5MDcsIm5iZiI6MCwiaWF0IjoxNTY3NzQ3MTA3LCJpc3MiOiJodHRwOi8vMTkyLjE2OC44OC4yMTo4MTgwL2F1dGgvcmVhbG1zL2V4cGVyaW1lbnRhbCIsImF1ZCI6Imh0dHA6Ly8xOTIuMTY4Ljg4LjIxOjgxODAvYXV0aC9yZWFsbXMvZXhwZXJpbWVudGFsIiwic3ViIjoiMTU4NDljNDUtOWUyMS00Zjk0LWI2ZjQtYTM5MjEzMjZkZDRiIiwidHlwIjoiUmVmcmVzaCIsImF6cCI6Im15YXBwIiwiYXV0aF90aW1lIjowLCJzZXNzaW9uX3N0YXRlIjoiYjE0YjY4OTQtMTVmNC00MTc2LWJiOTAtZGI5OGViODc5NGQ1IiwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbIm9mZmxpbmVfYWNjZXNzIiwidW1hX2F1dGhvcml6YXRpb24iXX0sInJlc291cmNlX2FjY2VzcyI6eyJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6InByb2ZpbGUgZW1haWwifQ.CEBbW31oeMlzHHRw3nwRd0nKq4jFC0KbsUBm5yMw-Ao",
  "token_type": "bearer",
  "not-before-policy": 0,
  "session_state": "b14b6894-15f4-4176-bb90-db98eb8794d5",
  "scope": "profile email"
}

Extraindo o access token 

export TKN=$(echo $RAWTKN | jq -r '.access_token')

curl "http://localhost:8000/pedidos/orders" \
-H "Accept: application/json" \
-H "Authorization: Bearer $TKN"