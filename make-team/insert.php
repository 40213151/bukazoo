<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] .'/functions.php');

//入力チェック(受信確認処理追加)
if(
    !isset($_POST["team_name"]) || $_POST["team_name"]=="" ||
    !isset($_POST["goal"]) || $_POST["goal"]=="" ||
    !isset($_POST["t_comment"]) || $_POST["t_comment"]==""
){
    exit('ParamError');
}

//1. POSTデータ取得

$team_name = $_POST["team_name"];
$goal = $_POST["goal"];
$t_comment = $_POST["t_comment"];
$user_id = $_SESSION["id"];


//2. DB接続します(エラー処理追加)
$pdo = db_con();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO bukazoo_team_table(id, team_name, goal, member_num, t_comment, captain, t_rgstdate)VALUES(NULL, :a1, :a2, NULL, :a4, :a5, sysdate())");
$stmt->bindValue(':a1', $team_name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $goal, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $t_comment, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a5', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    queryError($stmt);

}else{
    //５．index.phpへリダイレクト
    // $_SESSION["chk_ssid"]  = session_id();
    $stmt2 = $pdo->prepare('SELECT * FROM bukazoo_team_table WHERE id = (select max(id) from bukazoo_team_table where captain=:captain)');
    $stmt2->bindValue(':captain', $user_id);
    $res = $stmt2->execute();
    
    if($res==false){
      querryError($stmt);
    }

    $val = $stmt2->fetch(); //1レコードだけ取得する方法
    
    if( $val["id"] != "" ){
        $team_id = $val['id'];
      // $_SESSION["chk_ssid"]  = session_id();
      // $_SESSION["id"]   = $val['id'];
      // $_SESSION["user_id"]   = $val['user_id'];
    header("Location: /make-team/index2.php?team_id=$team_id");
    exit();
    };
};
?>