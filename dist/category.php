<?php

require('includes/header.php');
require('includes/navbar.php');

if (!isset($_GET["id"])) {
  ErrorMessage::show("No ID passed to page.");
}

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);

require('includes/footer.php');
