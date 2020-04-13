<?php

class Entity
{
  private $con, $sqlData;

  public function __construct($con, $input)
  {
    $this->con = $con;

    if (is_array($input)) {
      $this->sqlData = $input;
    } else {
      $query = $this->con->prepare("SELECT * FROM entities WHERE id = :id");
      $query->execute([':id' => $input]);

      $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function getID()
  {
    return $this->sqlData["id"];
  }

  public function getName()
  {
    return $this->sqlData["name"];
  }

  public function getPreview()
  {
    return $this->sqlData["preview"];
  }

  public function getThumbnail()
  {
    return $this->sqlData["thumbnail"];
  }

  public function getCategoryID()
  {
    return $this->sqlData["categoryId"];
  }

  public function getSeasons()
  {
    $query = $this->con->prepare('SELECT * FROM videos WHERE entityID = :id AND isMovie=0 ORDER BY season, episode ASC');
    $query->execute([':id' => $this->getID()]);

    $seasons = [];
    $videos = [];
    $currentSeason = null;

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

      if ($currentSeason != null && $currentSeason != $row['season']) {

        $seasons[] = new Season($currentSeason, $videos);
        $videos = [];
      }

      $currentSeason = $row['season'];
      $videos[] = new Video($this->con, $row);
    }

    if (sizeof($videos) != 0) {
      $seasons[] = new Season($currentSeason, $videos);
    }

    return $seasons;
  }
}
