<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanwei
 * Date: 2020/1/4
 * Time: 6:50 PM
 */
require_once __DIR__ . './../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', 'direct', false, false, false);

$severily = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = implode('', array_slice($argv, 2));
if (empty($data)) {
    $data = "Hello World";
}

$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'direct_logs', $severily);

echo " [x] Sent ",$severity,':',$data," \n";

$channel->close();
$connection->close();
