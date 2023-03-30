<?php
declare(strict_types=1);

require('vendor/autoload.php');

use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

// Instantiate an MQTT client instance
$client = new MqttClient('localhost', 1883);

$connectionSettings = (new ConnectionSettings)
    ->setUsername('admin')
    ->setPassword('admin')
    ->setKeepAliveInterval(60);

// Connect to the broker
$client->connect($connectionSettings);

// Subscribe to the topic
$client->subscribe('mqtt/last-will', function (string $topic, string $message) {
    echo "Received message on topic [$topic]: $message\n";
});

// Keep the script running to receive messages
$client->loop(true);
