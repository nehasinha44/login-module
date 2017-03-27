<?php
session_start();
ob_start();
$module_name = "sessionlogin";
include_once("config.php");
include_once("controller/Controller.php");
$controller = new Controller();
$controller->index();

?>
<link rel="stylesheet" type="text/css" href="components/login.css">
<script type="text/javascript" language="javascript"  src="components/index.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>