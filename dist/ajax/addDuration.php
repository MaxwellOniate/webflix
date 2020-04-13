<?php

require('../includes/config.php');

if (isset($_POST["videoID"]) && isset($_POST["username"])) {
  $query = $con->prepare("SELECT * FROM videoProgress WHERE username = :username AND videoId = :videoId");
  $query->execute([':username' => $_POST["username"], ':videoId' => $_POST["videoID"]]);

  if ($query->rowCount() == 0) {
    $query = $con->prepare("INSERT INTO videoProgress (username, videoId) VALUES (:username, :videoId)");
    $query->execute([':username' => $_POST["username"], ':videoId' => $_POST["videoID"]]);
  }
} else {
  echo 'No videoID or username passed into file.';
}
