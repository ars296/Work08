<?php
require_once('funcs.php');
$pdo = db_conn();

// 修正処理から戻ってきたときにURLにsuccessがあれば、この処理。
if ($_GET['success']) {
    $success = $_GET['success'];
}

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_user_table_with_photo');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    sql_error($status);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // GETデータ送信リンク作成
        // 編集対応する場合
        $view .= '<tr>';
        if ($result['Wants_flg']) {
            $view .= '<td> ✅ </td>';
        } else {
            $view .= '<td> - </td>';
        }
        if ($result['life_flg']) {
            $view .= '<td> ✅ </td>';
        } else {
            $view .= '<td> - </td>';
        }


        $view .= '<td class="pic"><a href="detail.php?id=' . $result['id'] . '">';
        $view .= $result['name'];
        $view .= '</a>';
        $view .= '</td>';

        $view .= '<td>';
        if (($result['img']) !== '') {
            $view .= '<img src="picture/' . $result['img'] . '">';
        }
        $view .= '</td>';

        // デリート対応する場合
        $view .= '<td><a href="delete.php?id=' . $result['id'] . '">';
        $view .= '<i class="fas fa-trash-alt"></i>';
        $view .= '</a>';
        $view .= '</td>';
        $view .= '</tr>';
    }
}

if ($view === '') {
    $view = '登録がまだないです';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>書籍一覧表示表示</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }

        th,
        td {
            text-align: center;
        }

        img {
            max-width: 50px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <?php
        // 修正処理から戻ってきたときにURLにsuccessがあれば、この処理。
        if ($success) {
            echo '<p class="text-success">編集できました😄👍</p>';
        }
        ?>
        <div class="container jumbotron">
            <table class="table">
                <thead>
                    <tr>
                        <th>欲しいもの</th>
                        <th>読了済</th>
                        <th>名前</th>
                        <th>本の写真</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $view ?>
                </tbody>
            </table>

        </div>
    </div>
    <!-- Main[End] -->

</body>

</html>
