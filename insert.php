<?php
session_start();
include("functions.php");
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["user_id"]) || $_POST["user_id"]=="" ||
  !isset($_POST["email"]) || $_POST["email"]=="" ||
  !isset($_POST["password"]) || $_POST["password"]=="" ||
  !isset($_POST["cnfrm_password"]) || $_POST["cnfrm_password"]==""
){
  exit('ParamError');
}
//1. POSTデータ取得
$name = $_POST["name"];
$user_id = $_POST["user_id"];
$email = $_POST["email"];
$password = $_POST["password"];
$cnfrm_password = $_POST["cnfrm_password"];

if($password != $cnfrm_password){
  exit('InputPasswordError');
};


//2. DB接続します(エラー処理追加)
$pdo = db_con();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO bukazoo_user_table(id, name, user_id, email, password, rgstdate)VALUES(NULL, :a1, :a2, :a3, :a4, sysdate())");
$stmt->bindValue(':a1', $name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $user_id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a4', $password, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  queryError($stmt);

}else{
    $stmt2 = $pdo->prepare('SELECT * FROM bukazoo_user_table WHERE user_id=:user_id AND password=:password');
    $stmt2->bindValue(':user_id', $user_id);
    $stmt2->bindValue(':password', $password);
    $res = $stmt2->execute();
    
//    3. SQL実行時にエラーがある場合
    if($res==false){
      querryError($stmt);
    }
    
    //4. 抽出データ数を取得
    //$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
    $val = $stmt2->fetch(); //1レコードだけ取得する方法
    
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
    }
    exit();
}
  exit();
?>
