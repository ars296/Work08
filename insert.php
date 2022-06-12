<?php
require_once('funcs.php');

//1. POSTデータ取得
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// ファイル名を決定。日付時間をファイル名に付与して、同じ名前をアップロードされても重複しないようにする。
// ファイル名のイメージは、'202206011415name.png'
$image = date('YmdHis') . $_FILES['image']['name'];

/**
 * (1)$_FILES['image']['tmp_name']... 一時的にアップロードされたファイル
 * (2)'../picture/' . $image...写真を保存したい場所。先に、pictureというフォルダを作成しておく。
 * (3)move_uploaded_fileで、（１）の写真を（２）に移動させる。
 */
move_uploaded_file($_FILES['image']['tmp_name'], 'picture/' . $image);
// 簡単なバリデーション処理。
// 名前、ID.PWが空白の場合、$err配列に1が挿入される
if (trim($_POST['name']) === '') {
    $err[] = '書籍名を確認してください。';
}
if (trim($_POST['lid']) === '') {
    $err[] = 'idを確認してください。';
}
if (trim($_POST['lpw']) === '') {
    $err[] = 'PWを確認してください。';
}

$fileName = $_FILES['image']['name'];
if (!empty($fileName)) {
    $check =  substr($fileName, -3);
    if ($check != 'jpg' && $check != 'gif' && $check != 'png') {
        $err[] = '本の写真の内容を確認してください。';
    }
}

// もしerr配列に何か入っている場合はエラーなので、redirect関数でindexに戻す。その際、GETでerrを渡す。
if (count($err) > 0) {
    foreach ($err as $val) {
        echo "<p>${val}</p>";
    }
    exit;
}

/*
* ※管理フラグ(formのチェックボックス)について。
* var_dumpで`$_POST`を確認すると、
* チェックがない場合は何も送られてこない($_POST['Wants_flg']が存在しない)
* チェックがついている場合は中身が、on（$_POST['Wants_flg']に何かが入っている）
* で送られてくることがわかる。
* よって、下記にてif文で 0 or 1を振り分けてあげる。
* （他にも方法があるかと思いますが、一例です。）
*/

if (isset($_POST['Wants_flg'])) {
    $Wants_flg = 1;
} else {
    $Wants_flg = 0;
}

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO
                        gs_user_table_with_photo(name,lid,lpw,Wants_flg,img)
                        VALUES
                        (:name,:lid,:lpw,:Wants_flg, :img)');
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_INT);
$stmt->bindValue(':Wants_flg', $Wants_flg, PDO::PARAM_STR);
$stmt->bindValue(':img', $image, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('index.php?success');
}
