<?php

class SeasonProvider
{
  private $con, $username;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;
  }

  public function create($entity)
  {
    $seasons = $entity->getSeasons();

    if (sizeof($seasons) == 0) {
      return;
    }

    $seasonsHTML = "

    ";

    foreach ($seasons as $season) {
      $seasonNumber = $season->getSeasonNumber();

      $videosHTML = "";
      foreach ($season->getVideos() as $video) {
        $videosHTML .= $this->createVideoSquare($video);
      }

      $seasonsHTML .= "
      <div class='season px-5'>
        <h3 class='heading'>Season $seasonNumber</h3>
        <div class='videos owl-carousel'>
          $videosHTML
        </div>
      </div>
      ";
    }
    return $seasonsHTML;
  }

  private function createVideoSquare($video)
  {
    $id = $video->getID();
    $thumbnail = $video->getThumbnail();
    $name = $video->getTitle();
    $description = $video->getDescription();
    $episodeNumber = $video->getEpisodeNumber();
    $hasSeen = $video->hasSeen($this->username) ? "<i class='fas fa-check-circle seen'></i>" : "";

    return "
    <a href='watch.php?id=$id'>
      <div class='episode-container'>
        <div class='contents'>
          <img src='$thumbnail' class='img-fluid'>
          <div class='video-info'>
            <h4>$episodeNumber. $name</h4>
            <span>$description</span>
            $hasSeen
          </div>
        </div>
      </div>
    </a>
    ";
  }
}
