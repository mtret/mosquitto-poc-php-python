<?php
declare(strict_types=1);

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

$server   = 'localhost';
$port     = 1883;
$clientId = (string)random_int(5, 15);
$username = 'admin';
$password = 'admin';
$clean_session = false;
$mqtt_version = MqttClient::MQTT_3_1_1;

$connectionSettings = (new ConnectionSettings)
    ->setUsername($username)
    ->setPassword($password)
    ->setKeepAliveInterval(60)
    ->setLastWillTopic('mqtt/last-will')
    ->setLastWillMessage('client disconnect')
    ->setLastWillQualityOfService(1);


$mqtt = new MqttClient($server, $port, $clientId);

$mqtt->connect($connectionSettings, $clean_session);
printf("client connected\n");

$mqtt->subscribe('mqtt/sub', function ($topic, $message) {
    printf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);

for ($i = 0; $i< 10; $i++) {
    $payload = array(
        'protocol' => 'tcp',
        'date' => date('Y-m-d H:i:s'),
        'url' => 'https://github.com/emqx/MQTT-Client-Examples'
    );
    $mqtt->publish(
    // topic
        'mqtt/pub',
        // payload
        json_encode($payload),
        // qos
        0,
        // retain
        true
    );
    printf("msg $i send\n");
    sleep(1);
}

$mqtt->loop(true);
