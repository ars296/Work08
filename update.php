<?php
session_start();
require_once('funcs.php');

//1. POSTデータ取得
$id = $_POST['id'];
$name = $_POST['name'];
$lid  = $_POST['lid'];
$lpw = $_POST['lpw'];
$Wants_flg = $_POST['Wants_flg'];
$Done_flg = $_POST['Done_flg'];

$err = [];
if (!$_FILES['image']['name']) {
    $image = $_SESSION['img'];
} else {
    $image = date('YmdHis') . rtrim($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], 'picture/' . $image);
    $fileName = $_FILES['image']['name'];

    if (!empty($fileName)) {
        $check =  substr($fileName, -3);
        if ($check != 'jpg' && $check != 'gif' && $check != 'png') {
            $err[] = '写真の内容を確認してください。';
        } else {
            unlink('picture/' . $_SESSION['img']);
        }
    }
}

if (trim($_POST['name']) === '') {
    $err[] = '名前を確認してください。';
}
if (trim($_POST['lid']) === '') {
    $err[] = 'idを確認してください。';
}
if (trim($_POST['lpw']) === '') {
    $err[] = 'PWを確認してください。';
}

if (count($err) > 0) {
    foreach ($err as $key => $val) {
        echo "<p>${val}</p>";
    }
    exit;
}

// 空白がなければ、$_POST["kanri_flg"]と、$_POST["life_flg"]をチェック
if (isset($_POST['Wants_flg'])) {
    $Wants_flg = 1;
} else {
    $Wants_flg = 0;
}

if (isset($_POST['Done_flg'])) {
    $Done_flg = 1;
} else {
    $Done_flg = 0;
}

//2. DB接続します
$pdo = db_conn();
//３．データ登録SQL作成
// ↓横に長いので、改行してます。横に1列で書いてもokです。
$stmt = $pdo->prepare('UPDATE
                            gs_user_table_with_photo
                        SET
                            name = :name,
                            lid = :lid,
                            lpw = :lpw,
                            Wants_flg = :Wants_flg,
                            Done_flg = :Done_flg,
                            img = :img
                        WHERE
                            id = :id;
                        ');
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':Wants_flg', $Wants_flg, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':Done_flg', $Done_flg, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':img', $image, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
} else {
    redirect("select.php?id=${id}&success=1");
}
