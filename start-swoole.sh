docker build . -f Dockerfile.Swoole -t websocket_benchmark/php-swoole && \
docker run --rm -p 8080:8080 websocket_benchmark/php-swoole
