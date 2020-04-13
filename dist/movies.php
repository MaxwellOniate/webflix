<?php

require('includes/header.php');
require('includes/navbar.php');

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createMoviePreviewVideo();

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showMovieCategories();

require('includes/footer.php');
