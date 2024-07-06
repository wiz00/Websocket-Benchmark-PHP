<?php

error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('memory_limit', '512M');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Benchmark\ServerRatchet as Server;

require __DIR__ . '/vendor/autoload.php';

// Generic Ratchet websocket server setup
// Custom logic is contained within src/Server.php
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server()
        )
    ),
    8080,
);

$server->run();
