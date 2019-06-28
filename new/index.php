<?php

session_start();
require('../config/config.php');

if (!empty($_POST)) {

    if ($_POST['name'] === '') {
        $eroor['name'] = 'brank';
    }
    if ($_POST['email'] === '') {
        $eroor['email'] = 'brank';
    }
    if (strlen($_POST['password']) < 4) {
        $error['password'] = 'length';
    }
    if ($_POST['password'] === '') {
        $eroor['password'] = 'brank';
    }

    if (empty($eroor)) {
        $_SESSION['join'] = $_POST;
        header('location: check.php');
        exit();
    }

    if (empty($error)) {
        $member = $db->prepare('SELECT COUNT(*) as count FROM users WHERE email=?');
        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if ($record['count'] > 0) {
            $error['email'] = 'duplicate';
        }
    }
}



if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>
    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/new.css" rel="stylesheet">

</head>

<body>

    <header>
        <h2>StarWars掲示板</h2>
    </header>
    <main>
    <div class="container">
        <div class="content">
            <div id="head">
                <h1>Welcome</h1>
            </div>

            <!-- valueはテキストフィールドの初期値 -->

            <div class="container" style="margin:0 auto;">
                <form action="" method="post" enctype="multipart/form-data">
                    <dl>

                        <dd>
                            <input type="text" name="name" size="35" maxlength="255" placeholder="Please Your Name" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" />
                            <?php if ($eroor['name'] === 'brank') : ?>
                                <p class="error">ニックネームを入力してください</p>
                            <?php endif; ?>
                        </dd>

                        <br><br>
                        <dd>
                            <input type="text" name="email" size="35" maxlength="255" placeholder="Please Your Email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />
                            <?php if ($error['email'] === 'brank') : ?>
                                <p class="error">メールアドレスを入力してください</p>
                            <?php endif; ?>
                            <?php if ($error['email'] === 'duplicate') : ?>
                                <p class="error">このメールアドレスはすでに登録されています</p>
                            <?php endif; ?>

                        <br>
                        <br>
                        <dd>
                            <input type="password" name="password" size="35" maxlength="20" placeholder="Please Your Password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
                            <?php if ($error['password'] === 'length') : ?>
                                <p class="error">パスワードは４文字以上で入力してください</p>
                            <?php endif; ?>

                            <?php if ($error['password'] === 'brank') : ?>
                                <p class="error">パスワードを入力してください</p>
                            <?php endif; ?>
                        </dd>

                    </dl>
                    <div><input class="btn" type="submit" value="入力内容を確認する" /></div>
                </form>
            </div>

        </div>
    </div>

</main>

    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>