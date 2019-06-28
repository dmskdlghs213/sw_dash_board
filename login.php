<?php
session_start();
require('config/config.php');

if ($_COOKIE['email'] !== '') {
    $email = $_COOKIE['email'];
}

if (!empty($_POST)) {
    if ($_POST['email'] != '' && $_POST['password'] != '') {
        $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
        $login->execute(array(
            $_POST['email'],
            sha1($_POST['password'])
        ));
        $member = $login->fetch();

        if ($member) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time'] = time();

            if ($_POST['save'] === 'on') {
                setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 14);
            }

            header('location: index.php');
            exit();
        } else {
            $error['login'] = 'failed';
        }
    } else {
        $error['login'] = 'blank';
    }
}

?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <title>Login</title>
</head>

<body>
    <header>
        <h2>StarWars 掲示板</h2>
    </header>
    <main>
        <div class="content">
            <div id="head">
                <h1>Login</h1>
            </div>
            <div id="content">
                <div id="lead">

                    <p>会員登録はこちら</p>
                    <p>&raquo;<a href="new/index.php">入会手続き</a></p>
                </div>
                <form action="" method="post">
                    <dl>

                        <dd>
                            <input type="text" name="email" size="35" maxlength="255" placeholder="Your Email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />

                        </dd>
                        <br>

                        <dd>
                            <input type="password" name="password" size="35" maxlength="255" placeholder="Your Password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
                        </dd>
                        <?php if ($error['login'] === 'blank') : ?>
                            <p class="error">メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>
                        <?php if ($error['login'] === 'failed') : ?>
                            <p class="error">ログインに失敗しました</p>
                        <?php endif; ?>
                        <br>
                        <dt>ログイン情報の記録</dt>
                        <dd>
                            <input id="save" type="checkbox" name="save" value="on">
                            <label for="save"></label>
                        </dd>
                    </dl>
                    <div>
                        <input class="btn" type="submit" value="ログインする" />
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>

</html>