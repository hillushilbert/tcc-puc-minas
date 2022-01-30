FROM python:3

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Create system user to run Composer and Artisan Commands
RUN useradd -G root -u $uid -d /home/$user $user && echo "$user:$user" | chpasswd && usermod -aG sudo $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    mkdir -p /var/app && \
    chown -R $user:$user /var/app

USER $user

RUN pip3 install configparser
RUN pip3 install boto3
RUN pip3 install pika
RUN pip3 install bson
RUN pip3 install pymongo
RUN pip3 install dnspython

# Set working directory
WORKDIR /var/app
# COPY ./src /
ADD src/*.py /var/app/

CMD [ "python", "-u", "/var/app/pipelineservice.py" ]