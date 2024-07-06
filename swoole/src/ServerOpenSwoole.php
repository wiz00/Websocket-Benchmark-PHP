<?php

namespace Benchmark;

/**
 * This class contains the custom logic for the
 * websocket server.
 * @package Benchmark
 */
class ServerOpenSwoole extends \OpenSwoole\WebSocket\Server
{
    protected array $clients;
    public bool $verbose = false;


    /**
     * Server constructor.
     * Initializes the clients member property
     */
    public function __construct(string $host, int $port = 0, int $mode = \OpenSwoole\Server::SIMPLE_MODE, int $sockType = \OpenSwoole\Constant::SOCK_TCP)
    {
        parent::__construct($host, $port, $mode, $sockType);

        // object store for connected clients
        $this->clients = [];
    }


    /**
     * Event triggered whenever a client connects to the websocket
     * @param int $connId The newly connected client
     * @return void
     */
    public function onOpen(int $connId): void
    {

        // Store the new connection to send messages to later
        $this->clients[$connId] = $connId;

        if ($this->verbose) {
            echo "New connection! ({$connId})\n";
        }

        // send newly connected client initial timestamp
        $this->notify($connId, 0);
    }


    /**
     * Event triggered whenever the server receives an incoming message from a client
     * @param int $from The client the incoming message is from
     * @param string $msg The incoming message
     * @return void
     */
    public function onMessage(int $from, string $msg): void
    {

        // decode incoming message into an associative array
        $incoming_message = json_decode($msg, true);
        // echo "incoming_message:\n";
        // var_dump($incoming_message);
        // echo "\n";

        // notify client with event for message with count "c"
        $this->notify($from, (int)$incoming_message["c"]);
    }


    /**
     * Event triggered whenever a client disconnects from the websocket server
     * @param int $connId The client that has disconnected
     * @return void
     */
    public function onClose(int $connId): void
    {

        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$connId]);

        if ($this->verbose) {
            echo "Connection {$connId} has disconnected\n";
        }
    }


    /**
     * Event triggered whenever an exception is thrown in the websocket server
     * @param int $connId The connected clients that triggered the exception
     * @param \Exception $e The exception being thrown
     * @return void
     */
    public function onError(int $connId, \Exception $e): void
    {
        if ($this->verbose) {
            echo "An error has occurred: {$e->getMessage()}\n";
        }

        // $conn->close();
    }


    /**
     * Gets the current unix timestamp of the server
     * @return int The current unix timestamp
     */
    private function getTimestamp(): int
    {
        return time();
    }


    /**
     * Creates a JSON string containing the message count and the current timestamp
     * @param int $c The message count
     * @return string A JSON string containing the message count and the current timestamp
     */
    private function getEvent(int $c): string
    {

        //create an event array for the time that message "c" is received by the server
        $event = [
            "c" => $c,
            "ts" => $this->getTimestamp(),
        ];

        // convert the array to a string
        return json_encode($event);
    }


    /**
     * Send a connected client an event JSON string
     * @param int $connId The client connection the outgoing message is for
     * @param int $c The message count
     * @return void
     */
    private function notify(int $connId, int $c): void
    {

        //send the given connection the event timestamp for message "c"
        $this->push($connId, $this->getEvent($c));

    }
}
