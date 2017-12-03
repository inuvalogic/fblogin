<?php

if (!session_id()) {
    session_start();
}

define('FB_APP_ID', '372275323194356');
define('FB_APP_SECRET', '5bd0cb7a911986a52c602e4c578642ee');

include 'vendor/autoload.php';