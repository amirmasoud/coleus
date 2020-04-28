ARG NODE_VERSION
FROM node:${NODE_VERSION}

COPY . /var/www/frontend

WORKDIR /var/www/frontend

RUN yarn install --frozen-lockfile && \
    yarn cache clean && \
    yarn build

ENV HOST 0.0.0.0
