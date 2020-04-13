<?php

require('includes/header.php');
require('includes/navbar.php');

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createTVShowPreviewVideo();

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showTVShowCategories();

require('includes/footer.php');
