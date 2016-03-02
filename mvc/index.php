<?php

require_once './library/config.php';

function __autoload($class_name) {
	require_once './library/' . $class_name . '.php';
}

$start = new Start();
