<?php
require_once('funcs.php');
$pdo = db_conn();
$id = $_GET['id'];

// まず保存された画像があれば削除する。
// まず画像があるか確認
$stmt = $pdo->prepare("SELECT img FROM gs_user_table_with_photo WHERE id=" . $id . ';');
$status = $stmt->execute();

// もし画像がある場合
if ($status !== false) {
    $row = $stmt->fetch();
    $imgName = $row['img'];
    unlink('picture/' . $imgName);
}

// データの削除
$stmt = $pdo->prepare('DELETE FROM gs_user_table_with_photo WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
