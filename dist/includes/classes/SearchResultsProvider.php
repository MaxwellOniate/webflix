<?php


class SearchResultsProvider
{
  private $con, $username;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;
  }

  public function getResults($inputText)
  {
    $entities = EntityProvider::getSearchEntities($this->con, $inputText);

    $html = "
    <div class='preview-categories px-5'>
    <h1>Search Results</h1>
    ";

    $html .= $this->getResultHTML($entities);

    return $html . "</div>";
  }

  private function getResultHTML($entities)
  {
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
      <div class='entities search-results'>
        $entitiesHTML
      </div>
    </div>
    ";
  }
}
