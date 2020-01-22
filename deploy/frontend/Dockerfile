FROM node:${NODE_VERSION}

COPY package.json yarn.lock /var/www/frontend/

WORKDIR /var/www/frontend

COPY . /var/www/frontend

RUN yarn install && yarn build

EXPOSE 3000
CMD ["yarn", "start"]
