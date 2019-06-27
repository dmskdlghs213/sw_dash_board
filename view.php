<?php

session_start();
require('config/config.php');

if (empty($_REQUEST['id'])) {
    header('location: index.php');
    exit();
}


$posts = $db->prepare('SELECT u.name,p.* FROM users u,posts p WHERE u.id=p.member_id AND p.id=?');

$posts->execute(array($_REQUEST['id']));

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Star Wars掲示板</title>

    <link rel="stylesheet" href="css/view.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-toggleable-md">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="#">StarWars 掲示板</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="content">
            <div class="head">
                <h1>スターウォーズ掲示板</h1>
            </div>
            <div id="content">
                <p>&laquo;<a href="index.php">一覧にもどる</a></p>
                <?php if ($post = $posts->fetch()) : ?>
                    <div class="msg">

                        <p><?php print(htmlspecialchars($post['message'])); ?>
                            <span class="name">（<?php print(htmlspecialchars($post['name'])); ?>）</span></p>
                        <p class="day"><?php print(htmlspecialchars($post['created'])); ?></p>
                    </div>
                <?php else : ?>
                    <p>その投稿は削除されたか、URLが間違えています</p>
                <?php endif;  ?>
            </div>
        </div>
    </main>
</body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</html>