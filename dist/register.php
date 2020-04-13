<?php

require('includes/config.php');
require('includes/classes/FormSanitizer.php');
require('includes/classes/Account.php');
require('includes/classes/Constants.php');

$account = new Account($con);

if (isset($_POST['submit'])) {
  $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
  $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
  $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

  $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

  if ($success) {

    $_SESSION["userLoggedIn"] = $username;

    header('Location: index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Webflix | Register</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

  <section id="register">
    <div class="overlay center">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <img src="assets/img/webflix.png" alt="Webflix" class="webflix">
            <h1 class="card-title">Sign Up</h1>
            <p>To continue to Webflix.</p>
            <form method="POST">

              <?php echo $account->getError(Constants::$firstNameCharacters); ?>
              <div class="form-group">
                <input type="text" name="firstName" class="form-control" placeholder="First Name" value="<?php $account->getInputValue("firstName"); ?>" required>
              </div>

              <?php echo $account->getError(Constants::$lastNameCharacters); ?>
              <div class="form-group">
                <input type="text" name="lastName" class="form-control" placeholder="Last Name" value="<?php $account->getInputValue("lastName"); ?>" required>
              </div>

              <?php echo $account->getError(Constants::$usernameCharacters); ?>
              <?php echo $account->getError(Constants::$usernameTaken); ?>
              <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php $account->getInputValue("username"); ?>" required>
              </div>

              <?php echo $account->getError(Constants::$emailsDontMatch); ?>
              <?php echo $account->getError(Constants::$emailInvalid); ?>
              <?php echo $account->getError(Constants::$emailTaken); ?>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php $account->getInputValue("email"); ?>" required>
              </div>

              <div class="form-group">
                <input type="email" name="email2" class="form-control" placeholder="Confirm Email" value="<?php $account->getInputValue("email2"); ?>" required>
              </div>

              <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
              <?php echo $account->getError(Constants::$passwordLength); ?>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>

              <div class="form-group">
                <input type="password" name="password2" class="form-control" placeholder="Confirm Password" required>
              </div>

              <div class="form-group">
                <input type="submit" name="submit" class=" btn btn-danger" value="SUBMIT">
              </div>
            </form>
            <p>Already have an account? Sign in <a href="login.php" class="text-danger">here</a>.</p>

          </div>

        </div>
      </div>
    </div>
  </section>


  <?php require('includes/footer.php'); ?>