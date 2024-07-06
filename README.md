# PHP Websocket Benchmark Server (Docker)

Based on [PHP (Ratchet)](https://github.com/matttomasetti/PHP-Ratchet_Websocket-Benchmark-Server) repository, and
[Websocket Performance Comparison](https://matttomasetti.medium.com/websocket-performance-comparison-10dc89367055) article,
implemented few PHP Websocket servers to be compared with each other and other technologies (languages).

* Ratchet is from the original repository, but moved to a subfolder.
* OpenSwoole is widely used but turned out to be almost as slow as Ratchet.
* **Workerman** is super fast.


## Benchmarking client

The benchmarking client can be found [here](https://github.com/wiz00/Websocket-Benchmark-Client)

## Install & run

### Ratchet PHP websocket server

```bash
docker build . -f Dockerfile.Ratchet -t websocket_benchmark/php-ratchet && \
docker run --rm -p 8080:8080 websocket_benchmark/php-ratchet
```

or

```bash
./start-ratchet.sh
```

### OpenSwoole PHP websocket server

```bash
docker build . -f Dockerfile.Swoole -t websocket_benchmark/php-swoole && \
docker run --rm -p 8080:8080 websocket_benchmark/php-swoole
```

or

```bash
./start-swoole.sh
```

### Workerman PHP websocket server

```bash
docker build . -f Dockerfile.Workerman -t websocket_benchmark/php-workerman && \
docker run --rm -p 8080:8080 websocket_benchmark/php-workerman
```

or

```bash
./start-workerman.sh
```

## Other websocket servers

* [Node](https://github.com/wiz00/Websocket-Benchmark-Node)
* [Python](https://github.com/wiz00/Websocket-Benchmark-Python)
* [PHP](https://github.com/wiz00/Websocket-Benchmark-PHP) (current)
* [Go](https://github.com/wiz00/Websocket-Benchmark-Go)

## Original comparison

* [Websocket Performance Comparison](https://matttomasetti.medium.com/websocket-performance-comparison-10dc89367055)
* [Technical Report](https://www.researchgate.net/publication/348993267_An_Analysis_of_the_Performance_of_Websockets_in_Various_Programming_Languages_and_Libraries)

## Original GitHub repositories

* [Benchmarking Client (NodeJS)](https://github.com/matttomasetti/NodeJS_Websocket-Benchmark-Client)
* [C (LWS)](https://github.com/matttomasetti/C-LWS_Websocket-Benchmark-Server)
* [C++ (uWS)](https://github.com/matttomasetti/CPP-uWS_Websocket-Benchmark-Server)
* [C# (Fleck)](https://github.com/matttomasetti/CS-Fleck_Websocket-Benchmark-Server)
* [Go (Gorilla)](https://github.com/matttomasetti/Go-Gorilla_Websocket-Benchmark-Server)
* [Java (WebSocket)](https://github.com/matttomasetti/Java-WebSocket_Websocket-Benchmark-Server)
* [NodeJS (uWS)](https://github.com/matttomasetti/NodeJS-uWS_Websocket-Benchmark-Server)
* [PHP (Ratchet)](https://github.com/matttomasetti/PHP-Ratchet_Websocket-Benchmark-Server)
* [Python (Websockets)](https://github.com/matttomasetti/Python-Websockets_Websocket-Benchmark-Server)
* [Python (Autobahn)](https://github.com/matttomasetti/Python-Autobahn_Websocket-Benchmark-Server)
* [Python (Aiohttp)](https://github.com/matttomasetti/Python-Aiohttp_Websocket-Benchmark-Server)
* [Rust (WebSocket)](https://github.com/matttomasetti/Rust-WebSocket_Websocket-Benchmark-Server)
