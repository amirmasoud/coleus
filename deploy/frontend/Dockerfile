FROM node:12.14.0-alpine

COPY . /var/www/frontend

WORKDIR /var/www/frontend

RUN yarn install && yarn build

EXPOSE 3000
CMD ["yarn", "start"]
