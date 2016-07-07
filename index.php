<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Dictionary Signin</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="includes/css/signin.css" rel="stylesheet">

  <body>

    <div class="container">
      <?php echo error(); ?>
      <form class="form-signin" action="authenticate.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" id="email" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only" >Password</label>
        <input type="password" id="inputPassword" class="form-control" name="password" id="password" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
      </form>

    </div>

  </body>
</html>
<?php require_once("includes/close_db.php"); ?>