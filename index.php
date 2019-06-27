<?php
session_start();
require('config/config.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time(); #時間の更新

    $members = $db->prepare('SELECT * FROM users WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
} else {
    header('location: login.php');
    exit();
}

if (!empty($_POST)) {
    if ($_POST['message'] !== '') {
        $message = $db->prepare('INSERT INTO posts SET member_id=?,name=?,message=?,created=NOW()');
        $message->execute(array(
            $member['id'],
            $member['name'],
            $_POST['message']
        ));

        header('location: index.php');
        exit();
    }
}

$posts = $db->query('SELECT users.name ,posts.* FROM users,posts WHERE users.id = posts.member_id ORDER BY posts.created DESC');


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Star Wars掲示板</title>

    <link rel="stylesheet" href="css/index.css" />
</head>

<body>
    <header>

        <nav class="navbar navbar-toggleable-md">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="index.php">StarWars 掲示板</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new/index.php">Signup</a>
                    </li>

                </ul>
            </div>
        </nav>


    </header>
    <main>
        <div class="content">
            <br>
            <div class="head">
                <h1>スターウォーズ掲示板</h1>
               
            </div>
            <div class="content">

                <form action="" method="post">
                    <dl>
                        <dt><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さん、ようこそ</dt>
                        <dd>
                            <textarea name="message" cols="50" rows="5"></textarea>
                            <input type="hidden" name="reply_post_id" value="" />
                        </dd>
                    </dl>
                    <div>
                        <p>
                            <input type="submit" value="投稿する" />
                        </p>
                    </div>
                </form>

                <?php foreach ($posts as $post) : ?>
                    <div class="msg">
                        <p> <a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?> "> <?php print(htmlspecialchars($post['message'], ENT_QUOTES)); ?></a>
                            <span class="name">（<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>）</span></p>
                        <p class="day"><?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></a>
                            <?php if ($_SESSION['id'] === $post['member_id']) : ?>
                                <a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>" style="color: #F33;">削除</a>
                            <?php endif; ?>
                        </p>
                        <br>
                    </div>

                <?php endforeach; ?>
                <ul class="paging">
                    <li><a href="index.php?page=">前のページへ</a></li>
                    <br><br>
                    <li><a href="index.php?page=">次のページへ</a></li>
                </ul>
            </div>
        </div>
    </main>
</body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


</html>