<?php 

$errors = array();

if (isset($_POST['submit'])) {
  if ($_POST['email'] == "" ) {
    $errors[] = "email input are empty";
  }
  elseif($_POST['password'] == ""){
    $errors[] = "password input are empty";
  }
  else {
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : "";

    $login = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $login->execute();
    $data = $login->fetch(PDO::FETCH_ASSOC);

    if ($login->rowCount() > 0) {
      if (password_verify($password, $data['mypassword'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        header("location: index.php");
      } else {
        $errors[] = "email or password is wrong";
      }
    } else {
      $errors[] = "email or password is wrong";
    }
  }
}
