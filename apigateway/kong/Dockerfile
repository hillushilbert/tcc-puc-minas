FROM kong:2.3.2-alpine
LABEL description="Alpine + Kong 2.3.2 + kong-jwt-keycloak plugin"

USER root
ENV KONG_PLUGINS="bundled,jwt-keycloak"

RUN apk update && apk add git unzip luarocks
# RUN luarocks install --pin lua-resty-jwt 0.2.2-0
# RUN luarocks install lua-resty-openidc 1.6.0
# RUN luarocks install kong-oidc
RUN luarocks install kong-plugin-jwt-keycloak

USER kong
