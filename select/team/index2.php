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
<link rel="stylesheet" href="/select/team/styles/main.css">

<!-- unique scripts -->
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="/select/team/scripts/modal.js"></script>
<script src="/select/team/scripts/wait_run.js"></script>
</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>

<?php 
    chkSSID();
    $team_id = $_GET["team_id"];
    $mission_id = $_GET["mission_id"];
    
    $pdo = db_con();
    
    $stmt = $pdo->prepare("SELECT * FROM bukazoo_team_table WHERE id=:id");
    $stmt->bindValue(":id",$team_id,PDO::PARAM_INT);
    $status = $stmt->execute();
    
    if($status==false){
      queryError($stmt);
    }else{
      $result = $stmt->fetch();
      $team_name = $result["team_name"];
      $goal = $result["goal"];
    };

    $stmt2 = $pdo->prepare("SELECT * FROM bukazoo_mission_table WHERE id=:id");
    $stmt2->bindValue(":id",$mission_id,PDO::PARAM_INT);
    $status2 = $stmt2->execute();
    
    if($status==false){
      queryError($stmt2);
    }else{
      $result = $stmt2->fetch();
      $m_distance = $result["m_distance"];
      $m_datetime = $result["m_datetime"];
      $m_coment = $result["m_coment"];
    };


 ?>

<main class="container" style="margin-top: 50px;">
    <input type="hidden" name="userId" value="<?=$user_id?>">
    <input type="hidden" name="userImg" value="<?=$user_img?>">
    <input type="hidden" name="teamId" value="<?=$team_id?>">
    <input type="hidden" name="missionId" value="<?=$mission_id?>">
    <input type="hidden" name="mDatetime" value="<?=$m_datetime?>">
<div class="about">
    <p class="text-center names">
        <?=$team_name?>
    </p>
    
    <p class="moku" style="text-align: center;">
        目標:<?=$goal?>
    </p>
</div>

    <div class="for-ajax-contents">
           
        <div class="texts">
            <p class="this-event-name">
                種目:ランニング<?=$m_distance?>km
            </p>
            <p class="this-event-time">
                開催時間：<?=$m_datetime?>~
            </p>
        </div>
        
        <div class="member-join">
            <p class="mp">参加メンバー : <span>0</span>人</p>
            <ul class="member-lists">

            </ul>
        </div>

        <div class="starting-time">
            <p class="timecountdown">開始まで... <span>00:00</span></p>
        </div>
        <button type="button" class="btn btn-group-justified btn-main-color" id="start_mission" onclick="window.location.href='/select/team/index3.php/?team_id=<?=$team_id?>&mission_id=<?=$mission_id?>'" disabled>start!</button>

    </div>

<script>
// $(function(){
//     $("#start_mission").click(function(){
//         $("html").fadeOut(600, function() {
//             window.location.href='/select/team/idex3.php/?team_id=<?=$team_id?>&mission_id=<?=$mission_id?>';
//                 // success: function(data) {
//                 //     $('html').html(data).fadeIn(600);;
//                 // error:function() {
//                 //     alert('問題がありました。');
//                 }
//             })
//         })
//     })
// });


// $(function(){
//     setTimeout(function(){
//         $("html").fadeOut(600, function() {
//             $.ajax({
//                 url: '/select/team/index3.php',
//                 type: 'GET',
//                 dataType: 'html',
//                 success: function(data) {
//                     $('html').html(data).fadeIn(600);;
//                 },
//                 error:function() {
//                     alert('問題がありました。');
//                 }
//             })
//         })
//     },6000)
// });

// $(function(){
//     setTimeout(function(){
//         $("html").fadeOut(600, function() {
//             $.ajax({
//                 url: '/select/team/index4.php',
//                 type: 'GET',
//                 dataType: 'html',
//                 success: function(data) {
//                     $('html').html(data).fadeIn(600);;
//                 },
//                 error:function() {
//                     alert('問題がありました。');
//                 }
//             })
//         })
//     },12000)
// });

 // function myfunc(y,m,d,h,m,url){
 //     var goTo = function(){location.href = url};
    
 //     //現在の時刻を秒数にする
 //     var now = new Date();
 //     var currentS = (now.getHours()*60 + now.getMinutes())*60 + now.getSeconds() ;
    
 //     //目標時刻を秒数にする
 //     var targetS = (h*60 + m)*60;
    
 //     //あと何秒で目標時刻になるか、差を求める(秒)
 //     var jisaS = targetS - currentS;
 //     //マイナスならすでに 今日は目標時刻を過ぎているということなので1日加算する
 //     if( jisaS < 0 ) jisaS += 24*60*60; //1日の秒数を加算
    
 //     //確認用
 //     alert("あと"+ jisaS +"秒で "+ h+"時"+ m +"分です");
 //     return setTimeout( goTo, jisaS*1000);
 // }
// myfunc(20,40,"./page02.html");
</script>

</main>
</div>

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>


</html>