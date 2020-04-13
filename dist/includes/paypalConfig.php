<?php

require("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
    // ClientID
    'AYAxynhZlTr7qbRbBXYivt7XhhppzKXVWnXoSWNj98F0pxTkpDxmqwTdN8faOiYQEmVMteeAlE2XkcmD',
    // ClientSecret
    'ECePPVf31VGZK6XoW3T8xZNKTLlDi1BJerGJzVK9EghXUPZGzTGc5XeXNreh1rwxmNhIOT791w5bJIYf'
  )
);
