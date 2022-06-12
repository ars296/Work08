<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>
    <?php

    // 簡単なバリデーション。どれか空白（読みたい書籍チェックは空白ok）の場合、insert.phpから戻される。
    if ($_GET['err']) {
        echo ('<p class="text-danger">書籍、ID、PWには必ず入力してください。</p>');
    }
    // 登録できた場合は↓
    if (isset($_GET['success'])) {
        echo ('<p class="text-success">登録できました！</p>');
    }

    ?>
    <!-- enctype="multipart/form-data" をつける。 -->
    <form method="POST" action="insert.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>書籍登録</legend>
                <label>書籍：<input type="text" name="name"></label><br>
                <label>ID:<input type="text" name="lid"></label><br>
                <label>PW：<input type="text" name="lpw"></label><br>
                <label>欲しいものリスト：<input type="checkbox" name="Wants_flg"></label><br>
                <!-- 写真を入れたい場合↓ -->
                <label>写真：<input type="file" name="image" size="35"></label><br>
                <input type="submit" value="登録">
            </fieldset>
        </div>
    </form>
</body>

</html>
