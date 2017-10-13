<?php
session_start();
$user_id = $_POST["user_id"];
$password = $_POST["inputPassword"];


//0.外部ファイル読み込み
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");



//1.  DB接続します
$pdo = db_con();

//2. データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM bukazoo_user_table WHERE user_id=:user_id AND password=:password');
$stmt->bindValue(':user_id', $user_id);
$stmt->bindValue(':password', $password);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if($res==false){
  querryError($stmt);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//5. 該当レコードがあればSESSIONに値を代入
if( $val["id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  // $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["id"]   = $val['id'];
  $_SESSION["user_id"]   = $val['user_id'];
  header("Location: /mypage");
}else{
  //logout処理を経由して全画面へ
  header("Location: /");
};

exit();
?>

