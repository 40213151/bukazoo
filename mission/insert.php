<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");

//入力チェック
if(
    !isset($_POST["date"]) || $_POST["date"]=="" ||
    !isset($_POST["time"]) || $_POST["time"]=="" ||
    !isset($_POST["time_limit"]) || $_POST["time_limit"]=="" ||
    !isset($_POST["m_distance"]) || $_POST["m_distance"]=="" ||
    !isset($_POST["team_id"]) || $_POST["team_id"]==""
){
    exit('ParamError');
}

$date       = $_POST["date"];
$time       = $_POST["time"];
$time_limit = $_POST["time_limit"];
$m_distance = $_POST["m_distance"];
$team_id    = $_POST["team_id"];


$pdo = db_con();


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO bukazoo_mission_table(id, m_distance, m_datetime, time_limit, team_id, accomp_flag, date_flag)VALUES( NULL, :a1, :a2, :a3, :a4, 0, 0)");
$stmt->bindValue(':a1', $m_distance, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $date."T".$time, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $time_limit, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $team_id, PDO::PARAM_INT);  //Integer（数値の場 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
//  $_SESSION["sm_ssid"]  = session_id();
  header("Location: /select/team/?team_id=$team_id");
  exit;

};
?>
