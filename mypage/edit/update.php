<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");

$id            = $_SESSION["id"];
$user_id       = $_POST["user_id"];
// $age           = $_POST["age"];
$intro_message = $_POST["intro_message"];

$pdo = db_con();

$stmt = $pdo->prepare("UPDATE bukazoo_user_table SET user_id=:user_id,intro_message=:intro_message WHERE id=:id");
$stmt->bindValue(':user_id',  $user_id,   PDO::PARAM_STR);
// $stmt->bindValue(':age', $age,  PDO::PARAM_STR);
$stmt->bindValue(':intro_message',$intro_message, PDO::PARAM_STR);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: /mypage");
  exit;
}


 ?>