docker build . -f Dockerfile.Reactphp -t websocket_benchmark/php-reactphp && \
docker run --rm --sysctl net.ipv4.ip_local_port_range="10000 65535" -p 8080:8080 websocket_benchmark/php-reactphp
