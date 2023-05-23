<?php
require "includes/header.php";
require "config.php";
//validar errores
$errors = array();
if (isset($_POST['submit'])) {
    // All fields are valid, proceed with further processing
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $post_id = isset($_POST['post_id']) ? htmlspecialchars($_POST['post_id']) : '';
    $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '';

    $insert = $conn->prepare("INSERT INTO users (username, post_id, comment) VALUES (:username, :post_id,:comment)");
    $insert->execute([
        ":username" => $username,
        ":post_id" => $post_id,
        ":comment" => $comment, 
    ]);
}


?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger" role="alert">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>