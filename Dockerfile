FROM tutum/apache-php
MAINTAINER Gabriel Minatto

COPY ./ /app/

RUN apt-get update