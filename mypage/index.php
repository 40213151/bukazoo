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
<link rel="stylesheet" href="/mypage/css/style.css">
<link rel="stylesheet" href="/mypage/css/calendar.css">
<link rel="stylesheet" href="/mypage/css/custom_1.css">

<!-- unique scripts -->
<!--for charts-->
<script src="/mypage/js/Chart.min.js"></script>
<script src="/mypage/js/data.js"></script>
<script src="/mypage/js/jquery.calendario.js"></script>
<script src="/mypage/js/modernizr.custom.63321.js"></script>

</head>

<body>
<!-- loginしていたら下記を読み込む -->
<?php
//  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>
<?php 

    
include($_SERVER['DOCUMENT_ROOT'] .'/functions.php');
chkSSID();
    
if(isset($_SESSION["id"])){
  $id = $_SESSION["id"];
}else{
  header("Location: /");
};

$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM bukazoo_user_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

$name="";
$user_id="";
$intro_message="";
$image="";
$team="";
if($status==false){
  queryError($stmt);
}else{
    $result = $stmt->fetch();
    $name = $result["user_id"];
    $user_id = $result["user_id"];
    // $age = $result["age"];
    $intro_message = $result["intro_message"];
    $image = $result["image"];
};

$stmt2 = $pdo->prepare("SELECT * FROM bukazoo_member_table WHERE user_id=:id");
$stmt2->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt2->execute();

while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
    $team_id = $row["team_id"];

    $stmt3 = $pdo->prepare("SELECT * FROM bukazoo_team_table WHERE id=:id");
    $stmt3->bindValue(":id",$team_id,PDO::PARAM_INT);
    $status3 = $stmt3->execute();
    if($status3==false){
        queryError($stmt3);
    }else{
        $result3 = $stmt3->fetch();
        $team_name = $result3["team_name"];
        $t_comment = $result3["t_comment"];
        $goal = $result3["goal"];
    };
    $team .= '<a href="/select/team?team_id='.$team_id.'" class="team">';
    $team .= '<div class="team-name">'.$team_name.'</div>';
    $team .= '<div class="　"></div>';
    $team .= '<label for="">GOAL: </label><div>'.$goal.'</div>';
    $team .= '</a>';
};
   
 ?>
<div class="mypage">
  <div class="filter">
  <main class="container">
    <div class="upper-content">
      <div class="left-content">
        <div>
          <button class="glyphicon glyphicon-edit" id="edit-profile" onclick="location.href='/mypage/edit'"></button>
        </div>
        <div>
          <p class="trim-image-to-circle" style='background-image: url("/mypage/img/<?=$image?>")'></p>
        </div>
        <div class="Doughnut-area">
          <canvas id="myDougnut"></canvas>
          <div class="percentage">
            <em>70</em>
            <span class="caption">%</span>
          </div>
        </div>
      </div>
      <div class="right-content">
        <p class="username"><?=$name?>    
        </p>
        <label for="userID">User ID: </label><p class="userID"><?=$user_id?></p>
        <!-- <label for="age">age: </label><p class="age"><?=$age?></p> -->
        <label for="introduction">introduction: </label><p class="introduction"><?=$intro_message?></p>
      </div>
    </div>
    <div>
     <div class="chart-area">
       <canvas id="myChart"></canvas>
     </div>
    </div>
    <div>
      <div>BUKAZ</div>

      <div class="bukaz">
        <?=$team?>
      </div>
    </div>
    <div class="schedule">
<!--      <div>SCHEDULE</div>-->
        <!-- <div id="calendar" class="fc-calendar-container"> -->
        <!-- <div class="fc-calendar fc-five-rows">
          <div class="fc-head">
          <div>Monday</div>
          <div>Tuesday</div>
          <div>Wednesday</div>
          <div>Thursday</div>
          <div>Friday</div>
          <div>Saturday</div>
          <div>Sunday</div>
          </div>
          <div class="fc-body">
          <div class="fc-row">
            <div></div>
            <div></div>
            <div></div>
            <div><span class="fc-date">1</span><span class="fc-weekday">Thu</span></div>
            <div><span class="fc-date">2</span><span class="fc-weekday">Fri</span></div>
            <div><span class="fc-date">3</span><span class="fc-weekday">Sat</span></div>
            <div><span class="fc-date">4</span><span class="fc-weekday">Sun</span></div>
          </div>-->
          <!-- <div class="fc-row"> -->
            <!-- ... -->
          <!-- </div> -->
          <!-- <div class="fc-row"> -->
            <!-- ... -->
          <!-- </div> -->
          <!-- <div class="fc-row"> -->
            <!-- ... -->
          <!-- </div> -->
          <!-- ... -->
          <!-- </div> -->
        <!-- </div>  -->
      </div>
  </main>
  </div>
</div>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

<!-- unique scripts -->
<script src="/mypage/js/functions.js"></script>


</body>


</html>