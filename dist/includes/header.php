<?php

require('includes/config.php');
require('includes/classes/PreviewProvider.php');
require('includes/classes/CategoryContainers.php');
require('includes/classes/Entity.php');
require('includes/classes/EntityProvider.php');
require('includes/classes/ErrorMessage.php');
require('includes/classes/SeasonProvider.php');
require('includes/classes/Season.php');
require('includes/classes/Video.php');
require('includes/classes/VideoProvider.php');
require('includes/classes/User.php');

if (!isset($_SESSION["userLoggedIn"])) {
  header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Webflix</title>
  <!-- FAVICON -->
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <!-- STYLE SHEETS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <!-- SCRIPTS -->
  <script src="https://kit.fontawesome.com/52d1564875.js" crossorigin="anonymous"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/script.js" defer></script>
</head>

<body>