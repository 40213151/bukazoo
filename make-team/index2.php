<?php session_start(); ?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" class="no-js">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">

<title>bukazoo</title>
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
<link rel="stylesheet" href="css/styles.css">
<link rel="icon" sizes="16x16 32x32 48x48 128x128 256x256" href=""> 

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/head.php');
?>

<!-- unique style -->


<!-- unique scripts -->

</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>
<?php 
$team_id = $_GET["team_id"];
$pdo = db_con();
$stmt = $pdo->prepare("SELECT * FROM bukazoo_team_table WHERE id=:id");
$stmt->bindValue(":id",$team_id,PDO::PARAM_INT);
$status = $stmt->execute();
if($status==false){
  queryError($stmt);
}else{
  $row = $stmt->fetch();
  $image = $row["image"];
}
 ?>

<main class="container" style="background-color:#283746  ;">
<div class="all">

<!--タイトル-->
<div class="title">
    <p>Select image</p>
</div>


<!--ステータス-->
<div class="row status">
    <div class="col-xs-12 img">
        <form method="post" name="File" action="/make-team/fileupload.php" enctype="multipart/form-data"> 
            <label for="file_photo" class="edit-image">
                <p class="trim-image-to-circle" style='background-image: url("/make-team/img/<?=$image?>");'></p>
                    <div class="edit-image-label">select new image</div>
                <input type="file" onchange="document.File.submit();" accept="image/*" id="file_photo" capture="camera" name="filename" style="display: none;">
                <input type="hidden" name="team_id" value="<?=$team_id?>">
            </label><br>
            <input type="submit" value="change photo" class="mod-image" style="display: none;">
        </form>
    </div>
</div>

    <div class="btn-outer">
<button class="button img-change-btn" onclick="location.href='/select'" style="color:#ffffff;">画像を決定する</button>
    </div>

</div>


<div class="container">
    
</div>



</main>

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>


</html>