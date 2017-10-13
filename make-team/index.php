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
<link rel="icon" sizes="16x16 32x32 48x48 128x128 256x256" href=""> 

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/head.php');
?>

<link rel="stylesheet" href="css/styles.css">
<!-- unique style -->


<!-- unique scripts -->

</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
  $_SESSION["user_id"] = $user_id;
?>


<main class="container" style="background-color:#283746  ;">

<!--タイトル-->
<div class="title">
    <p>Create team</p>
</div>


<!--ステータス-->



<div class="container">
    <form class="form-horizontal" method="post" action="/make-team/insert.php">

        <div class="form-group">
            <label>team name</label>
            <input type="text" name="team_name" class="form-control" placeholder="部活名を入力してください。">
        </div>

        <div class="form-group">
            <label>team goal</label>
            <input type="text" name="goal" class="form-control" placeholder="チームの目標を入力してください。">
        </div>

        <div class="form-group">
            <label>PR comment</label>
            <textarea class="form-control" rows="5" name="t_comment" id="comment" placeholder="PR文を入力してください。"></textarea>
        </div>
        
        <div class="form-group">
            <div class="btn-outer">
                <button type="submit" class="btn btn-default">次に画像を選択する</button>
            </div>
        </div>

    </form>
</div>



</main>

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>


</html>