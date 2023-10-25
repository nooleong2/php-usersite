<?php
session_start();

$session_id = ( isset($_SESSION["session_id"]) && $_SESSION["session_id"] != "") ? $_SESSION["session_id"] : "";
$session_level = ( isset($_SESSION["session_level"]) && $_SESSION["session_level"] != "") ? $_SESSION["session_level"] : "";