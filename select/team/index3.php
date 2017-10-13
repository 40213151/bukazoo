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
<script src="/select/team/scripts/functions.js"></script>
<script src="/select/team/scripts/modal.js"></script>



</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
    $img = $result["image"];


chkSSID();
$team_id = $_GET["team_id"];

$pdo = db_con();

$stmt3 = $pdo->prepare("SELECT * FROM bukazoo_team_table WHERE id=:id");
$stmt3->bindValue(":id",$team_id,PDO::PARAM_INT);
$status3 = $stmt3->execute();

if($status3==false){
    queryError($stmt3);
}else{
    $row = $stmt3->fetch();
    $team_name = $row["team_name"];
    $t_comment = $row["t_comment"];
    $goal = $row["goal"];
};

$mission_id = $_GET["mission_id"];

$stmt2 = $pdo->prepare("SELECT * FROM bukazoo_mission_table WHERE id=:id");
$stmt2->bindValue(":id",$mission_id,PDO::PARAM_INT);
$status2 = $stmt2->execute();

if($status2==false){
    queryError($stmt2);
}else{
    $row2 = $stmt2->fetch();
    $m_distance = $row2["m_distance"];
    $time_limit = $row2["time_limit"];
    $m_datetime = $row2["m_datetime"];
};




function json_safe_encode($data){
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
<script id="script" src="/select/team/scripts/firebase.js"
    m_distance         ='<?php echo json_safe_encode($m_distance); ?>'
    team_id         ='<?php echo json_safe_encode($team_id); ?>'
    mission_id         ='<?php echo json_safe_encode($mission_id); ?>'
    time_limit         ='<?php echo json_safe_encode($time_limit); ?>'
    m_datetime         ='<?php echo json_safe_encode($m_datetime); ?>'
></script>


<main class="container">

    <i class="glyphicon glyphicon-comment chat-btn">

    </i>

    <input type="hidden" name="userId" value="<?=$user_id?>">
    <input type="hidden" name="userImg" value="<?=$img?>">

    <p class="text-center"><?=$team_name?></p>
    <p>目標:<?=$goal?></p>

    <div class="for-ajax-contents">

        <p class="this-event-name">種目:ランニング<?=$m_distance?>km</p>

        <div id="checking-info" class="checking-info">
            <div class="wrap-info">
                <div class="wrap-info-goal">
                    Goal:<span>0</span>km
                </div>
                <div class="wrap-info-distance">
                    距離:<span>0.00</span>km
                </div>
                <div class="wrap-info-times">
                    時間:<span>00:00</span>
                </div>
            </div>
            <div id="each-person-now" class="each-person-now">
                <ul>
                    <li>
                        <div class="each-wrap-person">
                            <div class="each-bar-imgs">
                                <img src="/mypage/img/<?=$img?>" alt="">
                            </div>
                            <div class="each-bar"></div>
                        </div>
                    </li>
<!--                    <li style="left:80px">-->
<!--                        <div class="each-wrap-person">-->
<!--                            <div class="each-bar-imgs">-->
<!--                                <img src="/mypage/img/889937.jpg" alt="">-->
<!--                            </div>-->
<!--                            <div class="each-bar"></div>-->
<!--                        </div>-->
<!--                    </li>-->
                </ul>
            </div>
            <div class="progress-wrap">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">

                    </div>
                </div>
                <div class="start-wrap s-g-wrap">
                    <div class="each-bar"></div>
                    <p class="each-bar-words">Start!</p>
                </div>
                <ul id="wrap-distance-info">
                    <li>
                        <div class="each-bar"></div>
                        <p class="sep-distance"><span>1</span>km</p>
                    </li>
                    <li>
                        <div class="each-bar"></div>
                        <p class="sep-distance"><span>1</span>km</p>
                    </li>
                    <li>
                        <div class="each-bar"></div>
                        <p class="sep-distance"><span>1</span>km</p>
                    </li>
                    <li>
                        <div class="each-bar"></div>
                        <p class="sep-distance"><span>1</span>km</p>
                    </li>
                </ul>

                <div class="goal-wrap s-g-wrap">
                    <div class="each-bar"></div>
                    <p class="each-bar-words">Goal!</p>
                </div>
            </div>
        </div>

        <ul class="ranking-lists">
            <li class="ranking-each-person">
                <div class="ranking-user-img">
                    <img src="/mypage/img/<?=$img?>" alt="">
                </div>
                <ul>
                    <li><?=$user_id?></li>
                    <li class="ranking-dis-me">走った距離：<span>0.00</span>km</li>
                </ul>
            </li>
        </ul>
    </div>
</main>


<div class="modal fade" id="timeoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">RESULT</h4>
            </div>
            <div class="modal-body">
                TIME UP !!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="missionclearModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">RESULT</h4>
            </div>
            <div class="modal-body">
                MISSION CLEAR !!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<div id="modal-overlay"></div>

<div id="modal">
    <div class="modal-inner">
        <div class="modal-container">
            <i class="glyphicon glyphicon-remove close"></i>
            <div class="modal-chat">
                <ul>
                </ul>
            </div>
        </div>
        <div class="modal-input">
            <textarea name="" id="chat-textarea"></textarea>
            <button id="submit-btn">
                送信
            </button>
        </div>
    </div>
</div>



<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>


</html>