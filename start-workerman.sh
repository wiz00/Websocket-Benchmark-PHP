docker build . -f Dockerfile.Workerman -t websocket_benchmark/php-workerman && \
docker run --rm -p 8080:8080 websocket_benchmark/php-workerman
