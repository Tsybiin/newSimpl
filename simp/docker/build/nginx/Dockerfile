FROM nginx:latest
ARG DIR_SITE_CONTAINER

WORKDIR $DIR_SITE_CONTAINER
ADD nginx.conf /etc/nginx/nginx.conf
ADD fullchain.pem /etc/nginx/fullchain.pem
ADD privkey.pem /etc/nginx/privkey.pem
#RUN curl -sSL https://ngrok-agent.s3.amazonaws.com/ngrok.asc \
#  |  tee /etc/apt/trusted.gpg.d/ngrok.asc >/dev/null \
#  && echo "deb https://ngrok-agent.s3.amazonaws.com buster main" \
#  |  tee /etc/apt/sources.list.d/ngrok.list \
#  &&  apt update \
#  &&  apt install ngrok \
#ngrok config add-authtoken 'TOKEN'