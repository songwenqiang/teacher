<?php
session_start();

include_once("../include/functions.inc");

//
session_destroy();

jump("../index.php");

?>
