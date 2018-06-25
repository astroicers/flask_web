FROM alpine:3.6

RUN set -xe \
    && apk update \
    && apk upgrade \
    && apk add python \
    && apk add python-dev \
    && apk add py-pip \
    && apk add build-base \
    && apk add vim \
    && pip install --upgrade pip \
    && pip install requests \
    && pip install flask \
    && pip install pymongo \
    && mkdir flask_web

COPY ./ /config/flask_web

EXPOSE 5200

ENTRYPOINT [ "/bin/sh" ]