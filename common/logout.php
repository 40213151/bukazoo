<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] .'/functions.php');
chkSSID();
$_SESSION = array();
header("Location: /");
exit();
