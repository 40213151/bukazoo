<?php 
session_start();

$upload_file = "";
if(isset($_FILES['filename']) && $_FILES['filename']['error']==0){
    $upload_file = $_FILES['filename']['name'];
    $tmp_path = $_FILES['filename']['tmp_name'];
    $file_dir_path = $_SERVER['DOCUMENT_ROOT'] .'/make-team/img/';
    $img='';
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path,$file_dir_path.$upload_file)){
            chmod($file_dir_path.$upload_file, 0644);
            $img = '<img src="/make-team/img/'.$upload_file.'">';
        }else{
            echo 'FileUploadOK.....FileTransfer....Failed';
        };
    }else{
      echo 'FileUpload.......Failed';
    };
}else{
    echo 'Parrameter....Error';
};


include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");

$image   = $upload_file;
$team_id = $_POST["team_id"];
$pdo = db_con();

$stmt = $pdo->prepare("UPDATE bukazoo_team_table SET image=:image WHERE id=:id");
$stmt->bindValue(':image', $image,  PDO::PARAM_STR);
$stmt->bindValue(':id', $team_id,  PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: /make-team/edit/?team_id=$team_id");
  exit;
}


 ?>