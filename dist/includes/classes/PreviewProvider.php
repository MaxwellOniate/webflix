<?php

class PreviewProvider
{
  private $con, $username;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;
  }

  public function createCategoryPreviewVideo($categoryID)
  {
    $entitiesArray = EntityProvider::getEntities($this->con, $categoryID, 1);

    if (sizeof($entitiesArray) == 0) {
      ErrorMessage::show("No movies to display.");
    }

    return $this->createPreviewVideo($entitiesArray[0]);
  }

  public function createMoviePreviewVideo()
  {
    $entitiesArray = EntityProvider::getMovieEntities($this->con, null, 1);

    if (sizeof($entitiesArray) == 0) {
      ErrorMessage::show("No movies to display.");
    }

    return $this->createPreviewVideo($entitiesArray[0]);
  }

  public function createTVShowPreviewVideo()
  {
    $entitiesArray = EntityProvider::getTVShowEntities($this->con, null, 1);

    if (sizeof($entitiesArray) == 0) {
      ErrorMessage::show("No TV shows to display.");
    }

    return $this->createPreviewVideo($entitiesArray[0]);
  }

  public function createPreviewVideo($entity)
  {
    if ($entity == null) {
      $entity = $this->getRandomEntity();
    }

    $id = $entity->getID();
    $name = $entity->getName();
    $preview = $entity->getPreview();
    $thumbnail = $entity->getThumbnail();

    $videoID = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);

    $video = new Video($this->con, $videoID);

    $inProgress = $video->isInProgress($this->username);
    $playButtonText = $inProgress ? "Continue" : "Play";

    $seasonEpisode = $video->getSeasonAndEpisode();

    $subHeading = $video->isMovie() ? "" :
      "<h4>$seasonEpisode</h4>";

    return "
    <section class='preview'>

      <img src='$thumbnail' alt='$name' class='preview-img d-none'>

      <video class='preview-video' autoplay muted onended='previewEnded()'>
        <source src='$preview' type='video/mp4'>
      </video>


      <div class='overlay'>

          <div class='preview-details px-5'>

            <h3>$name</h3>
            $subHeading

            <div class='buttons'>

              <button onclick='playVideo($videoID)' class='btn btn-dark preview-btn'>
              <i class='fas fa-play'></i> $playButtonText
              </button>

              <button onclick='volumeToggle(this)' class='btn btn-dark preview-btn volume'>
              <i class='fas fa-volume-mute'></i>
              </button>

              <button class='btn btn-dark preview-btn replay d-none'>
              <i class='fas fa-redo'></i>
              </button>
              
            </div>
            
          </div>

      </div>

    </section>
    ";
  }

  public function createEntityPreviewSquare($entity)
  {
    $id = $entity->getID();
    $thumbnail = $entity->getThumbnail();
    $name = $entity->getName();

    return "
    
    <a href='entity.php?id=$id'>
      <div class='preview-container'>
        <img src='$thumbnail' title='$name' alt='$name' class='img-fluid'> 
      </div>
    </a>
    ";
  }

  private function getRandomEntity()
  {
    $entity = EntityProvider::getEntities($this->con, null, 1);

    return $entity[0];
  }
}
