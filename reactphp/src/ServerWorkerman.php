<?php

namespace Benchmark;

/**
 * This class contains the custom logic for the
 * websocket server.
 * @package Benchmark
 */
class ServerWorkerman extends \Workerman\Worker
{
    /**
     * @var \SplObjectStorage object that stores all connect clients
     */
    protected $clients;

    public bool $verbose = true;


    /**
     * Server constructor.
     * Initializes the clients member property
     */
    public function __construct($socket_name = '', array $context_option = array())
    {
        parent::__construct($socket_name, $context_option);

        // object store for connected clients
        $this->clients = new \SplObjectStorage();
    }


    /**
     * Event triggered whenever a client connects to the websocket
     * @param object $connection The newly connected client
     * @return void
     */
    public function onOpen($connection): void
    {
        // Store the new connection to send messages to later
        $this->clients->attach($connection);

        if ($this->verbose) {
            echo "New connection! ({$connection->id})\n";
        }

        // send newly connected client initial timestamp
        $this->notify($connection, 0);
    }


    /**
     * Event triggered whenever the server receives an incoming message from a client
     * @param object $connection The client the incoming message is from
     * @param string $msg The incoming message
     * @return void
     */
    public function onMessage($connection, string $msg): void
    {
        // decode incoming message into an associative array
        $incoming_message = json_decode($msg, true);

        // notify client with event for message with count "c"
        $this->notify($connection, (int)$incoming_message["c"]);
    }


    /**
     * Event triggered whenever a client disconnects from the websocket server
     * @param object $connection The client that has disconnected
     * @return void
     */
    public function onClose($connection): void
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($connection);

        if ($this->verbose) {
            echo "Connection {$connection->id} has disconnected\n";
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
     * @param object $connection The client connection the outgoing message is for
     * @param int $c The message count
     * @return void
     */
    private function notify($connection, int $c): void
    {
        //send the given connection the event timestamp for message "c"
        $connection->send($this->getEvent($c));
    }
}
