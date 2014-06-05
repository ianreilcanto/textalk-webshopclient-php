<?php

require(dirname(dirname(__FILE__)) . '/vendor/autoload.php');

use Textalk\ApiClient\Connection;
use Textalk\ApiClient\Instance;

$connection   = Connection::getDefault(array('webshop' => 22222));
$articlegroup = new Instance('Articlegroup', 1347891, $connection);

var_dump($articlegroup->get('name'));