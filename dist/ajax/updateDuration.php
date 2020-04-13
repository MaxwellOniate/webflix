<?php

require('../includes/config.php');

if (isset($_POST["videoID"]) && isset($_POST["username"]) && isset($_POST["progress"])) {
  $query = $con->prepare("UPDATE videoProgress SET progress = :progress, dateModified = NOW() WHERE username = :username AND videoId = :videoId");
  $query->execute([':username' => $_POST["username"], ':videoId' => $_POST["videoID"], ':progress' => $_POST["progress"]]);
} else {
  echo 'No videoID or username passed into file.';
}
