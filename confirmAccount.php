<?php

session_start();

if (!isset($_COOKIE["login"])) {
  session_destroy();
  header("Location: login.php");
}

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
} elseif ($_COOKIE["level"] == "user") {
  header("Location: index.php");
}


require "function.php";

$data = userNotActive();
$level = Level();

if (isset($_POST['submit_active'])) {
  if (activedAccount($_POST) > 0) {
    header("Location: confirmAccount.php");
    exit();
  } else {
    echo ("<script>
    alert('Gagal dirubah')
    </script>");
  }
}

if (isset($_POST['submit_delete'])) {
  if (delete($_POST) > 0) {
    header("Location: confirmAccount.php");
    exit();
  } else {
    echo ("<script>
    alert('Gagal dihapus')
    </script>");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="style/confAccount.css">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">Account</a>
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

  <div class="container_table">
    <div class="table">
      <table class="table">
        <thead>
          <tr class="header_tabel">
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Name</th>
            <th scope="col">Level</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $index) : ?>
            <tr class="isi_tabel">
              <th><?= $index["id"] ?></th>
              <td><?= $index["user_email"] ?></td>
              <td><?= $index["user_password"] ?></td>
              <td><?= $index["user_fullname"] ?></td>
              <td><?= $index["level"] ?></td>
              <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-accept<?= $index['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                  </svg>
                </button>
                <!-- notif terima -->
                <div class="modal fade" id="staticBackdrop-accept<?= $index['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <form action="" method="POST">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin untuk mengaktifkan akun <?= $index["user_fullname"] ?>
                        </div>
                        <input type="hidden" name="id" value="<?= $index['id'] ?>">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cencel</button>
                          <button type="submit" class="btn btn-success" name="submit_active">Ok</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end notif terima -->

                <!-- notif hapus -->
                <div class="modal fade" id="staticBackdrop-delete<?= $index['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <form action="" method="POST">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin untuk menghapus akun <?= $index["user_fullname"] ?>
                        </div>
                        <input type="hidden" name="id" value="<?= $index['id'] ?>">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cencel</button>
                          <button type="submit" class="btn btn-success" name="submit_delete">Ok</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end notif hapus -->

                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop-delete<?= $index['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z" />
                  </svg>
                </button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>