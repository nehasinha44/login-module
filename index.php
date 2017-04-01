<?php
session_start();
ob_start();
$module_name = "sessionlogin";
include_once "config.php";
include_once "controller/Controller.php";
$controller = new Controller();
$controller->index();

?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="components/login.css">
<script href="components/index.js" type="text/javascript" ></script>
