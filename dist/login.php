<?php

require('includes/config.php');
require('includes/classes/FormSanitizer.php');
require('includes/classes/Account.php');
require('includes/classes/Constants.php');

$account = new Account($con);

if (isset($_POST['submit'])) {
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

  $success = $account->login($username, $password);

  if ($success) {

    $_SESSION['userLoggedIn'] = $username;

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
  <title>Webflix | Login</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

  <section id="login">
    <div class="overlay center">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <img src="assets/img/webflix.png" alt="Webflix" class="webflix">
            <h1 class="card-title">Log In</h1>
            <p>To continue to Webflix.</p>
            <p>Username is "username"<br>Password is "password"</p>
            <form method="POST">

              <?php echo $account->getError(Constants::$loginFailed); ?>
              <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php $account->getInputValue("username"); ?>" required>
              </div>

              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>

              <div class="form-group">
                <input type="submit" name="submit" class="btn btn-danger" value="LOGIN">
              </div>
            </form>
            <p>Don't have an account? Sign up <a href="register.php" class="text-danger">here</a>.</p>

          </div>

        </div>


      </div>
    </div>
  </section>


  <?php require('includes/footer.php'); ?>