ARG NODE_VERSION
FROM node:${NODE_VERSION}

WORKDIR /var/www/admin

COPY . /var/www/admin

RUN yarn global add serve && \
    yarn install --frozen-lockfile --production --silent && \
    yarn cache clean && \
    yarn build && \
    rm -rf node_modules public src

EXPOSE 5000
ENV HOST 0.0.0.0
