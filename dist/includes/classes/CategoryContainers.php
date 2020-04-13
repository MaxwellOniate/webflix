<?php

class CategoryContainers
{
  private $con, $username;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;
  }

  public function showAllCategories()
  {
    $query = $this->con->prepare("SELECT * FROM categories");
    $query->execute();

    $html = "<section class='preview-categories px-5'>";

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $html .= $this->getCategoryHTML($row, null, true, true);
    }

    return $html . "</div>";
  }

  public function showMovieCategories()
  {
    $query = $this->con->prepare("SELECT * FROM categories");
    $query->execute();

    $html = "
    <section class='preview-categories px-5'>
    <h1>Movies</h1>
    ";

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $html .= $this->getCategoryHTML($row, null, false, true);
    }

    return $html . "</div>";
  }

  public function showTVShowCategories()
  {
    $query = $this->con->prepare("SELECT * FROM categories");
    $query->execute();

    $html = "
    <section class='preview-categories px-5'>
    <h1>TV Shows</h1>
    ";

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $html .= $this->getCategoryHTML($row, null, true, false);
    }

    return $html . "</div>";
  }

  public function showCategory($categoryID, $title = null)
  {
    $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
    $query->execute([':id' => $categoryID]);

    $html = "<section class='preview-categories no-scroll px-5'>";
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $html .= $this->getCategoryHTML($row, $title, true, true);
    }
    return $html . "</section>";
  }

  private function getCategoryHTML($sqlData, $title, $tvShows, $movies)
  {
    $categoryID = $sqlData["id"];
    $title = $title == null ?  $sqlData['name'] : $title;

    if ($tvShows && $movies) {
      $entities = EntityProvider::getEntities($this->con, $categoryID, 30);
    } else if ($tvShows) {
      $entities = EntityProvider::getTVShowEntities($this->con, $categoryID, 30);
    } else {
      $entities = EntityProvider::getMovieEntities($this->con, $categoryID, 30);
    }

    if (sizeOf($entities) == 0) {
      return;
    }

    $entitiesHTML = "";

    $previewProvider = new PreviewProvider($this->con, $this->username);

    foreach ($entities as $entity) {
      $entitiesHTML .= $previewProvider->createEntityPreviewSquare($entity);
    }

    return "
    <div class='category'>
      <a href='category.php?id=$categoryID' class='heading'>$title</a>
      <div class='entities owl-carousel'>
        $entitiesHTML
      </div>
    </div>
    ";
  }
}
