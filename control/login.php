<?php

$errors = array();

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $errors[] = "Email input is empty";
    } elseif (empty($_POST['password'])) {
        $errors[] = "Password input is empty";
    } else {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $login->bindParam(':email', $email);
        $login->execute();
        $data = $login->fetch(PDO::FETCH_ASSOC);

        if ($login->rowCount() > 0) {
            if (password_verify($password, $data['mypassword'])) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                header("location: index.php");
                exit();
            } else {
                $errors[] = "Email or password is wrong";
            }
        } else {
            $errors[] = "Email or password is wrong";
        }
    }
}


