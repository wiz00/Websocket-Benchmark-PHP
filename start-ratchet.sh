docker build . -f Dockerfile.Ratchet -t websocket_benchmark/php-ratchet && \
docker run --rm -p 8080:8080 websocket_benchmark/php-ratchet
