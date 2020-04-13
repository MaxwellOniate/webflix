<?php

require('includes/header.php');
require('includes/navbar.php');
require('includes/paypalConfig.php');
require('includes/classes/Account.php');
require('includes/classes/FormSanitizer.php');
require('includes/classes/Constants.php');
require('includes/classes/BillingDetails.php');

$user = new User($con, $userLoggedIn);

$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage = "";

if (isset($_POST["saveDetailsBtn"])) {
  $account = new Account($con);

  $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
  $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
  $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

  if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
    $detailsMessage = "
    <div class='alert alert-success' role='alert'>
      Account details updated.
    </div>
    ";
  } else {
    $errorMessage = $account->getFirstError();

    $detailsMessage = "
    <div class='alert alert-danger' role='alert'>
      $errorMessage
    </div>
    ";
  }
}

if (isset($_POST["savePasswordBtn"])) {
  $account = new Account($con);

  $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
  $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
  $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

  if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
    $passwordMessage = "
    <div class='alert alert-success' role='alert'>
      Password updated.
    </div>
    ";
  } else {
    $errorMessage = $account->getFirstError();

    $passwordMessage = "
    <div class='alert alert-danger' role='alert'>
      $errorMessage
    </div>
    ";
  }
}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
  $token = $_GET['token'];
  $agreement = new \PayPal\Api\Agreement();

  $subscriptionMessage = "
  <div class='alert alert-danger' role='alert'>
    Something went wrong!
  </div>";

  try {
    // Execute agreement
    $agreement->execute($token, $apiContext);

    $result = BillingDetails::insertDetails($con, $agreement, $token, $userLoggedIn);

    $result = $result && $user->setIsSubscribed(1);

    if ($result) {
      $subscriptionMessage = "
  <div class='alert alert-success' role='alert'>
    You have subscribed to Webflix!
  </div>";
    }
  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }
} else if (isset($_GET['success']) && $_GET['success'] == 'false') {
  $subscriptionMessage = "
  <div class='alert alert-danger' role='alert'>
    User cancelled or something went wrong!
  </div>";
}

?>

<section id="account" class="center">
  <div class="container">

    <div class="card">
      <div class="card-body">

        <h1 class="card-title">Update Account Details</h1>
        <p>Fill in the fields below.</p>

        <form method="post">

          <?php

          $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
          $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
          $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();

          ?>

          <?php echo $detailsMessage; ?>

          <div class="form-group">
            <input type="text" name="firstName" class="form-control" placeholder="First Name" value="<?php echo $firstName; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="lastName" class="form-control" placeholder="Last Name" value="<?php echo $lastName; ?>">
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
          </div>
          <div class="form-group">
            <input type="submit" name="saveDetailsBtn" value="Save" class="btn btn-danger">
          </div>
        </form>

        <hr>

        <h1 class="card-title">Change Password</h1>
        <p>Fill in the fields below.</p>

        <?php echo $passwordMessage; ?>

        <form method="post">
          <div class="form-group">
            <input type="password" name="oldPassword" class="form-control" placeholder="Old Password">
          </div>
          <div class="form-group">
            <input type="password" name="newPassword" class="form-control" placeholder="New Password">
          </div>
          <div class="form-group">
            <input type="password" name="newPassword2" class="form-control" placeholder="Confirm New Password">
          </div>
          <div class="form-group">
            <input type="submit" name="savePasswordBtn" value="Save" class="btn btn-danger">
          </div>
        </form>

        <hr>
        <h1 class="card-title">Subscription</h1>

        <?php echo $subscriptionMessage; ?>

        <?php

        if ($user->getIsSubscribed()) {
          echo '<p>You are subscribed! Go to PayPal to cancel.</p>';
        } else {
          echo "<a href='billing.php'>Subscribe to Webflix.</a>";
        }

        ?>

      </div>
    </div>

  </div>
</section>