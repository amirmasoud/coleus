ARG NODE_VERSION
FROM node:${NODE_VERSION}

RUN mkdir -p /var/www/image-conversion/node_modules && chown -R node:node /var/www/image-conversion

WORKDIR /var/www/image-conversion

COPY package*.json ./

USER node

RUN npm install

CMD [ "node", "server.js" ]
