FROM node:22

LABEL org.opencontainers.image.source="https://github.com/Jalle19/hs-debaiter"
LABEL org.opencontainers.image.licenses="GPL-2.0-only"
LABEL org.opencontainers.image.authors="Sam Stenvall <neggelandia@gmail.com>"

WORKDIR /app
COPY ../webui /app

RUN npm install

RUN npm run build

ENTRYPOINT ["node", "/app/build/index.js"]
