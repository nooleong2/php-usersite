<?php

include "../config/db_config.php";
include "../class/login.php";

$login = new Login($conn);
$login -> logout();