<?php session_start(); ?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" class="no-js">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">

<title>bakazoo</title>
<meta name="description" content="">
<meta name="keywords" content="">

<!-- sns -->

<meta property="og:title" content="">
<meta property="og:description" content="">
<meta property="og:type" content="website">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:site_name" content="">
<meta property="og:locale" content="ja_JP" />

<meta id="tw-text" property="tw:description" content="テキストが入ります" />

<!-- favicon icon -->

<link rel="icon" sizes="16x16 32x32 48x48 128x128 256x256" href=""> 

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/head.php');
?>

<!-- unique style -->
<link rel="stylesheet" href="/mypage/edit/css/style.css">

<!-- unique scripts -->
<!--for charts-->
<script src="/mypage/js/Chart.min.js"></script>


</head>

<body>
<!-- loginしていたら下記を読み込む -->
<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>

<?php
chkSSID();
$id = $_SESSION["id"];

$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM bukazoo_user_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
}



 ?>
<div class="mypage">
  <main class="container">
          <div class="upper-content">
            <div class="left-content">
              <div class="image-wrap">
                  <form method="post" name="File" action="/mypage/edit/fileupload.php" enctype="multipart/form-data"> 
                      <label for="file_photo" class="edit-image">
                          <p class="trim-image-to-circle" style='background-image: url("/mypage/img/<?=$row['image']?>")'></p>
                          <div class="edit-image-label">select new image</div>
                          <input type="file" onchange="document.File.submit();" accept="image/*" id="file_photo" capture="camera" name="filename" style="display: none;">
                      </label><br>
                      <input type="submit" value="change photo" class="mod-image" style="display: none;">
                  </form>
              </div>
            </div>
      <form method="post" action="/mypage/edit/update.php" class="right-content">
            <div>
              <p class="username"></p>
              <label for="userID">User ID: <br> <input type="text" class="userID" name="user_id" value="<?=$row['user_id']?>"></label>
              <!-- <label for="age">Birthday: <br> <input type="date" class="age" name="age" value="<?=$row['age']?>"></label> -->
              <label for="introduction">introduction:<br> <textarea name="intro_message" class="introduction" wrap=" soft"><?=$row['intro_message']?></textarea></label>
            </div>
          </div>
          <div class="bottom-content">
            <button class="cancel-button" onclick="location.href='/mypage'">cancel</button>
            <button class="ok-button" type="submit">OK</button>
          </div>
      </form>
  </main>
</div>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>



</body>


</html>