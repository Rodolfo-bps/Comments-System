<?php
require "includes/header.php";
require "config.php";

//validar errores
$errors = array();
if (isset($_POST['submit'])) {
  if ($_POST['email'] == '') {
    $errors[] = "email input are empty";
  } elseif ($_POST['username'] == '') {
    $errors[] = "user name input are empty";
  } elseif ($_POST['password'] == '') {
    $errors[] = "password  input are empty";
  } else {
    // Perform individual validations for each field
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format";
    } elseif (strlen($_POST['username']) < 5) {
      $errors[] = "Username must be at least 5 characters long";
    } elseif (strlen($_POST['password']) < 8) {
      $errors[] = "Password must be at least 8 characters long";
    } else {
      // All fields are valid, proceed with further processing
      $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
      $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
      $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

      $insert = $conn->prepare("INSERT INTO users (email, username, mypassword) VALUES (:email, :username,:mypassword)");
      $insert->execute([
        ":email" => $email,
        ":username" => $username,
        ":mypassword" => password_hash($password, PASSWORD_DEFAULT)
      ]);
    }
  }
}

?>
<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">

    <h1 class="h3 mt-5 fw-normal text-center">Please Register</h1>
    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger" role="alert">
        <ul>
          <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username">
      <label for="floatingInput">Username</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">register</button>
    <h6 class="mt-3">Aleardy have an account? <a href="login.php">Login</a></h6>

  </form>
</main>
<?php require "includes/footer.php"; ?>