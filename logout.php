<?php
require_once('classes/Authentication.php');
$auth = new Authentication();
$auth->logout();
header('location: index.php');
?>