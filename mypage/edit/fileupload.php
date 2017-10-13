<?php 
session_start();

$upload_file = "";
if(isset($_FILES['filename']) && $_FILES['filename']['error']==0){
    $upload_file = $_FILES['filename']['name'];
    $tmp_path = $_FILES['filename']['tmp_name'];
    $file_dir_path = $_SERVER['DOCUMENT_ROOT'] .'/mypage/img/';
    $img='';
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path,$file_dir_path.$upload_file)){
            chmod($file_dir_path.$upload_file, 0644);
            $img = '<img src="/mypage/img/'.$upload_file.'">';
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

$id            = $_SESSION["id"];
$image         = $upload_file;

$pdo = db_con();

$stmt = $pdo->prepare("UPDATE bukazoo_user_table SET image=:image WHERE id=:id");
$stmt->bindValue(':image', $image,  PDO::PARAM_STR);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: /mypage/edit");
  exit;
}


 ?>