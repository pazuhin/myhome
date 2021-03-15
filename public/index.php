<?php

use core\App as App;

require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/core/App.php';
require_once dirname(__DIR__) . '/core/libs/functions.php';
require_once CONF . '/routes.php';
session_start();

$app = new App();