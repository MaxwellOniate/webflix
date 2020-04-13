<?php

class EntityProvider
{
  public static function getEntities($con, $categoryID, $limit)
  {
    $sql = "SELECT * FROM entities ";

    if ($categoryID != null) {
      $sql .= "WHERE categoryID= :categoryID ";
    }

    $sql .= "ORDER BY RAND() LIMIT :limit";

    $query = $con->prepare($sql);

    if ($categoryID != null) {
      $query->bindValue(':categoryID', $categoryID);
    }

    $query->bindValue(':limit', $limit, PDO::PARAM_INT);

    $query->execute();

    $result = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $result[] = new Entity($con, $row);
    }

    return $result;
  }

  public static function getTVShowEntities($con, $categoryID, $limit)
  {
    $sql = "SELECT DISTINCT(entities.id) 
    FROM entities
    INNER JOIN videos
    ON entities.id = videos.entityId
    WHERE videos.isMovie = 0 ";

    if ($categoryID != null) {
      $sql .= "AND categoryID= :categoryID ";
    }

    $sql .= "ORDER BY RAND() LIMIT :limit";

    $query = $con->prepare($sql);

    if ($categoryID != null) {
      $query->bindValue(':categoryID', $categoryID);
    }

    $query->bindValue(':limit', $limit, PDO::PARAM_INT);

    $query->execute();

    $result = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $result[] = new Entity($con, $row["id"]);
    }

    return $result;
  }

  public static function getMovieEntities($con, $categoryID, $limit)
  {
    $sql = "SELECT DISTINCT(entities.id) 
    FROM entities
    INNER JOIN videos
    ON entities.id = videos.entityId
    WHERE videos.isMovie = 1 ";

    if ($categoryID != null) {
      $sql .= "AND categoryID= :categoryID ";
    }

    $sql .= "ORDER BY RAND() LIMIT :limit";

    $query = $con->prepare($sql);

    if ($categoryID != null) {
      $query->bindValue(':categoryID', $categoryID);
    }

    $query->bindValue(':limit', $limit, PDO::PARAM_INT);

    $query->execute();

    $result = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $result[] = new Entity($con, $row["id"]);
    }

    return $result;
  }

  public static function getSearchEntities($con, $term)
  {
    $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30";

    $query = $con->prepare($sql);

    $query->execute([':term' => $term]);

    $result = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $result[] = new Entity($con, $row);
    }

    return $result;
  }
}
