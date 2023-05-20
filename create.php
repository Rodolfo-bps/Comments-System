<?php
require "includes/header.php";
require "config.php";

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$errors = array();

if (isset($_POST['submit'])) {
    if ($_POST['title'] == '' || $_POST['body'] == '') {
        $errors[] = "Some inputs are empty";
    } else {
        // Perform individual validations for each field
        if (strlen($_POST['title']) < 10) {
            $errors[] = "Title must be at least 5 characters long";
        } elseif (strlen($_POST['body']) < 50) {
            $errors[] = "Body must be at least 200 characters long";
        } else {
            // All fields are valid, proceed with further processing
            $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
            $body = isset($_POST['body']) ? htmlspecialchars($_POST['body']) : '';
            $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

            $insert = $conn->prepare("INSERT INTO posts (title, body, username) VALUES (:title, :body, :username)");
            $insert->execute([
                ":title" => $title,
                ":body" => $body,
                ":username" => $username
            ]);
            header("location: index.php");
        }
    }
}

?>

<main class="form-signin w-50 m-auto">
    <form method="POST" action="create.php">

        <h1 class="h3 mt-5 fw-normal text-center">Create Post</h1>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li><br>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-floating">
            <input name="title" type="text" class="form-control" id="floatingInput" placeholder="Title">
            <label for="floatingInput">Title</label>
        </div>

        <div class="form-floating mt-4">
            <textarea name="body" id="" cols="30" rows="10" placeholder="body" class="form-control"></textarea>
            <label for="floatingPassword">Body</label>
        </div>

        <button name="submit" class="w-100 btn btn-lg btn-primary mt-5" type="submit">Create Post</button>

    </form>
</main>

<?php require "includes/footer.php"; ?>