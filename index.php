<?php

session_start();

if (!isset($_COOKIE["login"])) {
  session_destroy();
  header("Location: login.php");
}

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
}

require "function.php";

$data = userActive();
$level = Level();

if (isset($_POST['submit_edit'])) {
  if (update($_POST) > 0) {
    header("Location: index.php");
    exit();
  } else {
    echo ("<script>
    alert('Gagal dirubah')
    </script>");
  }
}

if (isset($_POST['submit_add'])) {
  if (insert($_POST) > 0) {
    header("Location: index.php");
    exit();
  } else {
    echo ("<script>
    alert('Gagal ditambah')
    </script>");
  }
}

if (isset($_POST['submit_delete'])) {
  if (delete($_POST) > 0) {
    header("Location: index.php");
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
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="style/index_style.css">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">Dashboard</a>
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
      <form action="" method="POST">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- ID Otomatis -->
              <input type="hidden" class="form-control field-edit" id="id" value="<?= autoID("SELECT id FROM user_detail ORDER BY id DESC") ?>" name="id">

              <label for="email" class="form-label">User Email</label>
              <input type="email" class="form-control field-edit" id="email" email="exampleInputPassword1" name="email" required>

              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control field-edit" id="password" name="password" required>

              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control field-edit" id="name" name="name" required>

              <label class="form-label" for="level">Level</label>
              <div class="dropdown_combobox">
                <select class="dropdown-level" id="level" name="level">
                  <?php foreach ($level as $dropdown) : ?>
                    <option class="dropdown-item"><?= $dropdown["level"] ?></option>
                  <?php endforeach ?>
                </select>
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
    <div class="table">
      <table class="table">
        <thead>
          <tr class="header_tabel">
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Name</th>
            <th scope="col">Level</th>
            <?php if ($_COOKIE["level"] == "admin") : ?>
              <th scope="col">Action</th>
            <?php endif ?>
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
              <?php if ($_COOKIE["level"] == "admin") : ?>
                <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-notif<?= $index['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                      <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                    </svg>
                  </button>
                  <!-- notif edit -->
                  <div class="modal fade" id="staticBackdrop-notif<?= $index['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <form action="" method="POST">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" class="form-control field-edit" id="id" value="<?= $index['id'] ?>" name="id">

                            <label for="email" class="form-label">User Email</label>
                            <input type="email" class="form-control field-edit" id="email" email="exampleInputPassword1" value="<?= $index["user_email"] ?>" name="email" required>

                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control field-edit" id="password" value="<?= $index["user_password"] ?>" name="password" disabled required>

                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control field-edit" id="name" value="<?= $index["user_fullname"] ?>" name="name" required>

                            <label class="form-label" for="level">Level</label>
                            <div class="dropdown_combobox">
                              <select class="dropdown-level" id="level" name="level">
                                <?php foreach ($level as $dropdown) : ?>
                                  <?php if ($dropdown["level"] == $index["level"]) : ?>
                                    <option class="dropdown-item" selected><?= $dropdown["level"] ?></option>
                                  <?php elseif ($dropdown["level"] != $index["level"]) : ?>
                                    <option class="dropdown-item"><?= $dropdown["level"] ?></option>
                                  <?php endif ?>
                                <?php endforeach ?>
                              </select>
                            </div>

                            <div class="footer-edit">
                              <button type="button" class="btn btn-secondary btn-footer" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary btn-footer" name="submit_edit" data-bs-dismiss="modal">Edit</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- end notif edit -->

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
                            Apakah anda yakin untuk menghapus data <?= $index["user_fullname"] ?>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                      <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                    </svg>
                  </button>
                </td>
              <?php endif ?>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>