<?php

session_start();
require "function.php";

$gambar = gambar();

if (!isset($_COOKIE["login"])) {
  session_destroy();
  header("Location: login.php");
}

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
}

if (isset($_POST["submit_add"])) {
  if (upGambar($_FILES["foto"], "galery.php") > 0) {
    header("Location: galery.php");
    exit();
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="style/galery_style.css">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">Galery</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              More
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="index.php">Dashboard</a></li>
              <?php if ($_COOKIE["level"] == "admin") : ?>
                <li><a class="dropdown-item" href="confirmAccount.php">Confirm Account</a></li>
              <?php endif ?>
              <li><a class="dropdown-item" href="galery.php">Galery</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container_add">
    <?php if ($_COOKIE["level"] == "admin") : ?>
      <button type="button" class="btn btn-success btn_add" data-bs-toggle="modal" data-bs-target="#staticBackdrop-tambah">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
          <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
          <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
        </svg>
        Add Data
      </button>
    <?php endif ?>

    <!-- Notif Tambah -->
    <div class="modal fade" id="staticBackdrop-tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Images</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="formFile" class="form-label">Silahkan pilih beberapa gambar</label>
                <input type="file" name="foto[]" multiple />
              </div>

              <div class="footer-edit">
                <button type="button" class="btn btn-secondary btn-footer" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-footer" name="submit_add">Add</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- end notif tambah -->
  </div>


  <div class="container_table">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th>id</th>
          <th>gambar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($gambar as $indexGambar) : ?>
          <tr>
            <td><?= $indexGambar["gambar_id"] ?></td>
            <td><img src="gambar/<?= $indexGambar["gambar_nama"] ?>" alt="" class="gambar"></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

</body>

</html>