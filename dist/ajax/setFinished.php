<?php

require('../includes/config.php');

if (isset($_POST["videoID"]) && isset($_POST["username"])) {
  $query = $con->prepare("UPDATE videoProgress SET finished =1, progress = 0 WHERE username = :username AND videoId = :videoId");
  $query->execute([':username' => $_POST["username"], ':videoId' => $_POST["videoID"]]);
} else {
  echo 'No videoID or username passed into file.';
}
