<?php
define('NETSDIAL', true);
require_once dirname(__DIR__) . '/config/config.php';
session_destroy();
redirect('/admin/login.php');
