<?php
session_start();

require "function.php";

$data = userActive();

if (isset($_COOKIE["login"])) {                                                
  if ($_COOKIE["login"] == "true") {
    $_SESSION["login"] = "true";
  }
}

if(isset($_SESSION["login"])){
  header("Location: index.php");
  exit();
}

if (isset($_POST["submit"])) {
  foreach ($data as $index) {
    if ($index["user_email"] == $_POST["email"] && $index["user_password"] == md5($_POST['password'])) {
      $time = 120;
      setcookie('login', 'true', time() + $time);
      setcookie('level', $index["level"], time() + $time);
      header('Location: login.php');
      exit();
    }
  }
  echo ("<script>alert('Username atau password anda salah')</script>");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="style/login_style.css">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

  <div class="container">
    <h1 class="title_login">Login</h1>
    `<form action="" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
      </div>
      <div class="mb-3 create">
        <p class="create_account">click register <a href="register.php">here</a></p>
      </div>
      <br>
      <button type="submit" class="btn btn-primary btnOk" name="submit">Login</button>
    </form>
  </div>
</body>

</html>