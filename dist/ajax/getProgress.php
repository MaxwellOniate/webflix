<?php

require('../includes/config.php');

if (isset($_POST["videoID"]) && isset($_POST["username"])) {
  $query = $con->prepare("SELECT progress FROM videoProgress WHERE username = :username AND videoId = :videoId");
  $query->execute([':username' => $_POST["username"], ':videoId' => $_POST["videoID"]]);
  echo $query->fetchColumn();
} else {
  echo 'No videoID or username passed into file.';
}
