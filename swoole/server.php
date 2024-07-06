<?php

ini_set('memory_limit', '512M');

// use OpenSwoole\WebSocket\Server;
use OpenSwoole\WebSocket\Frame;
use Benchmark\ServerOpenSwoole as Server;

require __DIR__ . '/vendor/autoload.php';

$server = new Server("0.0.0.0", 8080);
$server->set([
    'log_level' => OpenSwoole\Constant::LOG_INFO,
]);

$server->on("Start", function (Server $server) {
    if ($server->verbose) {
        echo "OpenSwoole WebSocket Server started at 127.0.0.1:8080\n";
    }
});

$server->on('Open', function (Server $server, OpenSwoole\Http\Request $request) {
    if ($server->verbose) {
        echo "Connection open: {$request->fd}\n";
    }

    $server->onOpen($request->fd);
});

$server->on('Message', function (Server $server, Frame $frame) {
    if ($server->verbose) {
        echo "Received message: {$frame->data}\n";
    }
    $server->onMessage($frame->fd, $frame->data);
});

$server->on('Close', function (Server $server, int $fd) {
    if ($server->verbose) {
        echo "Connection close: {$fd}\n";
    }
    $server->onClose($fd);
});

$server->on('Disconnect', function (Server $server, int $fd) {
    if ($server->verbose) {
        echo "Connection disconnect: {$fd}\n";
    }
});

$server->start();
