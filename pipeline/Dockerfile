FROM python:3

# ADD pipelineservice.py /
# ADD pipeline.conf /
COPY ./src /

RUN pip3 install configparser
RUN pip3 install boto3
RUN pip3 install pika
RUN pip3 install bson
RUN pip3 install pymongo
RUN pip3 install dnspython

CMD [ "python", "-u", "./pipelineservice.py" ]