#!/bin/bash

#mkdir ../public/swagger

php ../vendor/bin/openapi --bootstrap ./swagger-constants.php --output ../public/openapi/assets ./swagger-v1.php ../app/Http/Controllers/Api