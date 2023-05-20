<?php
require "includes/header.php";
require "config.php";

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$select = $conn->query("SELECT * FROM posts");
$select->execute();
$rows = $select->fetchAll(PDO::FETCH_OBJ);
?>

<h1 class="text-center mt-3"> POSTS
</h1>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <?php foreach($rows as $row): ?>
        <div class="card mt-3">
            <div class="card-header">
                <?= "Author ".$row->username ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $row->title ?></h5>
                <p class="card-text"><?= substr($row->body, 0, 100)," ..." ?></p>
                <a href="show.php?id=<?= $row->id ?>" class="btn btn-primary">More</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-3"></div>
</div>


<?php require "includes/footer.php"; ?>