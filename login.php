<?php require "includes/header.php";

require "config.php";

$errors = array();

if (isset($_POST['submit'])) {
  if ($_POST['email'] == "" or $_POST['password'] == "") {
    $errors[] = "Some inputs are empty";
  } else {
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

?>
<?php if (count($errors) > 0) : ?>
  <div class="alert alert-danger" role="alert">
    <ul>
      <?php foreach ($errors as $error) : ?>
        <li><?= $error ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<main class="form-signin w-50 m-auto">
  <form method="POST" action="login.php">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="h3 mt-5 fw-normal text-center">Please sign in</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <h6 class="mt-3">Don't have an account <a href="register.php">Create your account</a></h6>
  </form>
</main>
<?php require "includes/footer.php"; ?>