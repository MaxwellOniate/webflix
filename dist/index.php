<?php

require('includes/header.php');
require('includes/navbar.php');

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showAllCategories();

require('includes/footer.php');
