<?php

require('../includes/config.php');
require('../includes/classes/SearchResultsProvider.php');
require('../includes/classes/EntityProvider.php');
require('../includes/classes/Entity.php');
require('../includes/classes/PreviewProvider.php');

if (isset($_POST["term"]) && isset($_POST["username"])) {
  $srp = new SearchResultsProvider($con, $_POST["username"]);
  echo $srp->getResults($_POST["term"]);
} else {
  echo 'No term or username passed into file.';
}
