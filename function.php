<?php

use LDAP\Result;

$conn = mysqli_connect("localhost", "root", "", "user");

function userActive(){
    global $conn;

    $users = [];

    $result = mysqli_query($conn, "SELECT user_detail.id, user_detail.user_email, user_detail.user_password, user_detail.user_fullname, level_detail.level FROM level_detail JOIN user_detail ON level_detail.id_level = user_detail.level where user_detail.status = 'active' ORDER BY user_detail.id ASC");

    while($user = mysqli_fetch_assoc($result)){
        $users[] = $user;
    }
    return $users;
}

function gambar(){
  global $conn;

  $users = [];

  $result = mysqli_query($conn, "SELECT * FROM gambar");

  while($user = mysqli_fetch_assoc($result)){
      $users[] = $user;
  }
  return $users;
}

function upGambar($gambar, $lokasi){
  global $conn;

  $jumlahGambar = count($_FILES["foto"]["name"]);
  $ekstensi = array('png', 'jpg', 'jpeg', 'gif');
  $result = "";

  for($i=0; $i<$jumlahGambar; $i++){
    $id = autoIDGambar("SELECT * FROM gambar ORDER BY gambar_id DESC");

    $namaFile = $_FILES["foto"]["name"][$i];
    $tmpFile = $_FILES["foto"]["tmp_name"][$i];
    $tipe_file = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $ukuranFile = $_FILES["foto"]["size"][$i];
    $error = $_FILES["foto"]["error"];

    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $tipe_file;

    if(!in_array($tipe_file, $ekstensi)){
      echo ("<scrip>
        alert 'Extensi file salah';
      </script>");
      header("Location: $lokasi");
    }else{
      if($error === 4){
        echo ("<scrip>
          alert 'Anda tidak memilih file';
        </script>");
        header("Location: $lokasi");
      }else{
        mysqli_query($conn, "INSERT INTO gambar VALUES('$id', '$namaFileBaru')");
        move_uploaded_file($tmpFile, 'gambar/' . $namaFileBaru);
      }
    }
  }
  return mysqli_affected_rows($conn);
}

function userNotActive(){
  global $conn;

  $users = [];

  $result = mysqli_query($conn, "SELECT user_detail.id, user_detail.user_email, user_detail.user_password, user_detail.user_fullname, level_detail.level FROM level_detail JOIN user_detail ON level_detail.id_level = user_detail.level where user_detail.status = 'not-active'");

  while($user = mysqli_fetch_assoc($result)){
      $users[] = $user;
  }
  return $users;
}

function levelSelected($id){
  global $conn;

  $users = [];

  $result = mysqli_query($conn, "SELECT level_detail.level FROM level_detail JOIN user_detail ON level_detail.id_level = user_detail.level WHERE user_detail.id='$id'");

  while($user = mysqli_fetch_assoc($result)){
      $users[] = $user;
  }
  return $users;
}

function Level(){
  global $conn;

  $users = [];

  $result = mysqli_query($conn, "SELECT level FROM level_detail");

  while($user = mysqli_fetch_assoc($result)){
      $users[] = $user;
  }
  return $users;
}

function levelToIdLevel($level){
  global $conn;

  $array= [];
  $hasil = "";

  $result = mysqli_query($conn, "SELECT id_level FROM level_detail WHERE level = '$level'");

  while($anu = mysqli_fetch_assoc($result)){
    $array[] = $anu;
  }

  foreach ($array as $index){
    $hasil = $index["id_level"];
  }

  return $hasil;

}

function update($data){

  global $conn;

  $id = $data["id"];
  $email = $data["email"];
  $password = $data["password"];
  $name = $data["name"];
  $level = levelToIdLevel($data["level"]);

  $query = "UPDATE user_detail SET
            user_email = '$email',
            user_password = '$password',
            user_fullname = '$name',
            level = '$level' 
            WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

function autoID($query){
  global $conn;

  $raw = mysqli_query($conn, $query);

  $Result = mysqli_fetch_assoc($raw);

  $finalResult =  $Result["id"]+1;

  return $finalResult;
}

function autoIDGambar($query){
  global $conn;

  $raw = mysqli_query($conn, $query);

  $Result = mysqli_fetch_assoc($raw);

  $finalResult =  $Result["gambar_id"]+1;

  return $finalResult;
}
function insert($data){

  global $conn;

  $id = autoID("SELECT id FROM user_detail ORDER BY id DESC");
  $email = $data["email"];
  $password = md5($data["password"]);
  $name = $data["name"];
  $status = 'active';
  $level = levelToIdLevel($data["level"]);

  $query = "INSERT INTO user_detail VALUES ('$id','$email','$password','$name','$status',$level)";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

function delete($data){

  global $conn;

  $id = $data['id'];

  $query = "DELETE FROM user_detail WHERE id='$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

function activedAccount($data){

  global $conn;

  $id = $data['id'];

  $query = "UPDATE user_detail set status = 'active' WHERE id='$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

}

class register{
  function execute($data){

  global $conn;

  $id = autoID("SELECT id FROM user_detail ORDER BY id DESC");
  $email = $data["email"];
  $password = md5($data["password"]);
  $name = $data["name"];
  $status = "not-active";
  $level = 2;

  $query = "INSERT INTO user_detail VALUES ('$id','$email','$password','$name','$status',$level)";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);

  }
}

?>