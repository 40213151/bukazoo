<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");

$id            = $_SESSION["id"];

$team_id       = $_POST["team_id"];
$team_name = $_POST["team_name"];
$goal = $_POST["goal"];
$t_comment = $_POST["t_comment"];

$pdo = db_con();

$stmt = $pdo->prepare("UPDATE bukazoo_team_table SET team_name=:team_name, goal=:goal, t_comment=:t_comment WHERE id=:team_id");
$stmt->bindValue(':team_name',  $team_name,   PDO::PARAM_STR);
$stmt->bindValue(':goal',       $goal,        PDO::PARAM_STR);
$stmt->bindValue(':t_comment',  $t_comment,   PDO::PARAM_STR);
$stmt->bindValue(':team_id',    $team_id,     PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: /select");
  exit;
}


 ?>