<?php

class VideoProvider
{
  public static function getUpNext($con, $currentVideo)
  {
    $query = $con->prepare("SELECT * FROM videos WHERE entityId = :entityID AND id != :videoID AND ((season = :season AND episode > :episode) OR season > :season) ORDER BY season, episode ASC LIMIT 1");

    $query->execute([
      ':entityID' => $currentVideo->getEntityID(),
      ':season' => $currentVideo->getSeasonNumber(),
      ':episode' => $currentVideo->getEpisodeNumber(),
      ':videoID' => $currentVideo->getID()
    ]);

    if ($query->rowCount() == 0) {
      $query = $con->prepare("SELECT * FROM videos WHERE season <=1 AND episode <= 1 and id != :videoID ORDER BY RAND() DESC LIMIT 1");

      $query->execute([':videoID' => $currentVideo->getID()]);
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);

    return new Video($con, $row);
  }

  public static function getEntityVideoForUser($con, $entityID, $username)
  {
    $query = $con->prepare('SELECT videoId FROM videoProgress INNER JOIN videos ON videoProgress.videoId = videos.id WHERE videos.entityId = :entityID AND videoprogress.username = :username ORDER BY videoprogress.dateModified DESC LIMIT 1');

    $query->execute([
      ':entityID' => $entityID,
      ':username' => $username
    ]);

    if ($query->rowCount() == 0) {
      $query = $con->prepare('SELECT id FROM videos WHERE entityId = :entityID ORDER BY season, episode ASC LIMIT 1');

      $query->execute([':entityID' => $entityID]);
    }

    return $query->fetchColumn();
  }
}
