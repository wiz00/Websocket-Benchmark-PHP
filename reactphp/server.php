<?php

ini_set('memory_limit', '128M');

use Benchmark\ServerWorkerman as Server;

require __DIR__ . '/vendor/autoload.php';

// Create a Websocket server
$server = new Server('websocket://0.0.0.0:8080');

// Emitted when new connection come
$server->onConnect = function ($connection) use ($server) {
    // echo "New connection\n";
    $server->onOpen($connection);
};

// Emitted when data received
$server->onMessage = function ($connection, $data) use ($server) {
    // echo "Message\n";
    $server->onMessage($connection, $data);
};

// Emitted when connection closed
$server->onClose = function ($connection) use ($server) {
    // echo "Connection closed\n";
    $server->onClose($connection);
};

// Run worker
Server::runAll();
