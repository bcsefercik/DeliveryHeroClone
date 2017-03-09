<?php
session_start();
include('../includes/config.php'); include('../includes/functions.php');

unset($_SESSION["u_user"]);
unset($_SESSION["u_username"]);


session_destroy();

echo redirectUrl($site_address); exit;
?>