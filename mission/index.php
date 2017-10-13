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

<!-- unique style -->
<link rel="stylesheet" href="css/style.css">

<!-- unique scripts -->

</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
  $team_id = $_GET["team_id"];
?>


<main class="container">
    <div class="title">
        <p>Create mission</p>
    </div>
    
    <div class="container">
       
    <form method="post" action="insert.php" class="row">
       
<!--        <ul class="form-list col-xs-12">-->
<!--            <dl class="form-item">-->
<!--              <dt for="time" class="form-label"><p>時間帯</p></dt>-->
<!--              <dd class="form-detail time-table">-->
<!--                   <input class="form-parts" type="date" name="date" required>-->
<!--                   <input class="form-parts" type="time" name="time" required>-->
<!--               </dd>-->
<!--            </dl>-->
<!--            <dl class="form-item">-->
<!--                <dt for="time_limit" class="form-label"><p>制限時間</p></dt>-->
<!--                <dd class="form-detail">-->
<!--                    <input type="text" class="form-parts" name="time_limit" placeholder="min." required>-->
<!--                </dd>-->
<!--            </dl>-->
<!--            <dl class="form-item">-->
<!--                <dt for="km" class="form-label"><p>走行距離</p></dt>-->
<!--                <dd class="form-detail">-->
<!--                    <input type="text" class="form-parts" name="m_distance" placeholder="Km" required>-->
<!--                </dd>-->
<!--            </dl>-->
<!--           -->
<!--
<!--            -->
<!--        </ul>-->
<!--        <input type="hidden" name="team_id" value="--><?//=$team_id?><!--">-->
<!--        <button type="submit" class="btn">-->
<!--            <p>作成</p>-->
<!--        </button>-->
        <div class="form-group">
            <label>開始時間</label>
            <dd class="form-detail time-table">
                <input class="form-parts" type="date" name="date" required>
                <input class="form-parts" type="time" name="time" required>
            </dd>
        </div>

        <div class="form-group">
            <label>走行距離</label>
            <input type="text" name="m_distance" class="form-control" placeholder="km" required>
        </div>

        <div class="form-group">
            <label>制限時間</label>
            <input type="text" class="form-control" name="time_limit" placeholder="min." required>
        </div>
        <input type="hidden" name="team_id" value="<?=$team_id?>">
        <div class="form-group">
            <div class="btn-outer">
                <button type="submit" class="btn btn-default">Missionを作成</button>
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