<?php


class User
{
  private $con, $sqlData;

  public function __construct($con, $username)
  {
    $this->con = $con;

    $query = $con->prepare("SELECT * FROM users WHERE username=:username");

    $query->execute([":username" => $username]);

    $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
  }

  public function getFirstName()
  {
    return $this->sqlData["firstName"];
  }

  public function getLastName()
  {
    return $this->sqlData["lastName"];
  }
  public function getEmail()
  {
    return $this->sqlData["email"];
  }
  public function getUsername()
  {
    return $this->sqlData["username"];
  }
  public function getIsSubscribed()
  {
    return $this->sqlData["isSubscribed"];
  }
  public function setIsSubscribed($value)
  {
    $query = $this->con->prepare("UPDATE users SET isSubscribed=:isSubscribed WHERE username=:un");

    if ($query->execute([
      ":isSubscribed" => $value,
      ":un" => $this->getUsername()
    ])) {
      $this->sqlData["isSubscribed"] = $value;
      return true;
    }

    return false;
  }
}
