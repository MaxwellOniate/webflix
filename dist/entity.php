<?php

require('includes/header.php');
require('includes/navbar.php');


if (!isset($_GET['id'])) {
  ErrorMessage::show("No ID passed into the page.");
}

$entityID = $_GET['id'];
$entity = new Entity($con, $entityID);



$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($con, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($con, $userLoggedIn);
echo $categoryContainers->showCategory($entity->getCategoryID(), 'You might also like...');

?>

<?php require('includes/footer.php'); ?>