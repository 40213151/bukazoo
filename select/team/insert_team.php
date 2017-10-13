<?php
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['user_id']) || $_POST['user_id']=="" ||
  !isset($_POST['team_id']) || $_POST['team_id']=="" ||
  !isset($_POST['status']) || $_POST['status']==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$user_id = $_POST['user_id'];
$team_id = $_POST['team_id'];
$status = $_POST['status'];


//2. DB接続します(エラー処理追加)

$pdo = db_con();

//３．データ登録SQL作成
if($status==0){
    $stmt = $pdo->prepare("INSERT INTO bukazoo_member_table(id, user_id, team_id, rgst_date)VALUES(NULL, :user_id, :team_id, sysdate())");
}else if($status==1){
    $stmt = $pdo->prepare("DELETE FROM bukazoo_member_table WHERE user_id=:user_id AND team_id=:team_id");
}
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':team_id', $team_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
  //５．index.phpへリダイレクト
  header("Location: /select/team/?team_id=$team_id");
  exit;
}
?>
