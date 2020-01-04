<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanwei
 * Date: 2020/1/4
 * Time: 8:57 AM
 */
require_once __DIR__ . './../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

$data = implode('', array_slice($argv, 1));

if (empty($data)) {
    $data = 'Hello Wrold';
}

$msg = new AMQPMessage($data,  array('delivery_mode' => 2));

$channel->basic_publish($msg, '', 'task_queue');

echo " [x] Sent ", $data, "\n";

