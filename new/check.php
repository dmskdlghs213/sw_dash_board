<?php
session_start();
require('../config/config.php');

if (!isset($_SESSION['join'])) {
    header['location: index.php'];
    exit();
}

if (!empty($_POST)) {
    $statement = $db->prepare('INSERT INTO users SET name=?,email=?,password=?,created=NOW()');
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['email'],
        sha1($_SESSION['join']['password']),
    ));
    unset($_SESSION['join']);
    header('location: welcome.php');
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>

    <link rel="stylesheet" href="../css/new.css" />
</head>

<body>
    <header>
        <h2>スターウォーズ掲示板</h2>
    </header>
    <main>
        <div class="content">
            <div class="head">
                <h1>Welcome</h1>
            </div>

            <div id="content">
                <p>登録内容を確認しよう</p>
                <br>
                <form action="" method="post">
                    <input type="hidden" name="action" value="submit" />
                    <dl>
                        <dt>Your Name</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>
                        </dd>
                        <br><br>
                        <dt>Your Email</dt>
                        <dd>
                            <?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
                        </dd>
                        <br>


                        </dd>
                    </dl>
                    <br>
                    <div><a href="index.php?action=rewrite">&laquo;&nbsp;内容を編集する</a> | <input class="btn" type="submit" value="登録する" /></div>
                </form>
            </div>

        </div>
    </main>
</body>

</html>