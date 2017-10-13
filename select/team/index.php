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
    <link rel="stylesheet" href="/select/team/styles/main.css">

    <!-- unique scripts -->

</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>
<?php
chkSSID();
$team_id = $_GET["team_id"];

$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM bukazoo_team_table WHERE id=:id");
$stmt->bindValue(":id",$team_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
    queryError($stmt);
}else{
    $row = $stmt->fetch();
    $team_name = $row["team_name"];
    $t_comment = $row["t_comment"];
    $goal = $row["goal"];
    $image = $row["image"];
};





$stmt2 = $pdo->prepare("SELECT * FROM bukazoo_mission_table WHERE team_id=:id");
$stmt2->bindValue(":id",$team_id,PDO::PARAM_INT);
$status2 = $stmt2->execute();

$team_mission="";
if($status2==false){
    queryError($stmt2);
}else{
    while( $row = $stmt2->fetch(PDO::FETCH_ASSOC)){
    //     $m_datetime = $row["m_datetime"];
    //     $time_limit = $row["time_limit"];
    //     $date1 = new DateTime($m_datetime);
    //     $now = new DateTime();
    //     $date1->add(new DateInterval('PT$time_limit.i'));
    //     echo $date->format('Y-m-d H:i:s')
    //     $mission_id = $row["id"];
    //     if($date1>$now){
            $team_mission .= '<div class="mission-lists col-xs-12">';
            $team_mission .= '<a href="/select/team/index2.php/?team_id='.$team_id.'&mission_id='.$row["id"].'">';
            $team_mission .= '<div>';
            $team_mission .= '<span class="span_1">種目</span>ランニング'.h($row["m_distance"]).'km';
            $team_mission .= '<br>';
            $team_mission .= '<span class="span_2">開催日</span>'.h($row["m_datetime"]);
            $team_mission .= '</div>';
            $team_mission .= '</a>';
            $team_mission .= '<div class="move-to-wait-page">→</div>';
            $team_mission .= '</div>';
        // };
    };
};


if(isset($_SESSION["id"])){
    $user_id = $_SESSION["id"];
}
$stmt3 = $pdo->prepare("SELECT * FROM bukazoo_member_table WHERE user_id=:user_id AND team_id=:team_id");
$stmt3->bindValue(":user_id",$user_id,PDO::PARAM_INT);
$stmt3->bindValue(":team_id",$team_id,PDO::PARAM_INT);
$status3 = $stmt3->execute();


$hide1="";
$hide2="";
if($status==false){
    queryError($stmt);
}else{
    $resultSet = $stmt3->fetchAll();
    $resultNum = count($resultSet);

    if($resultNum==0){
        $team_mission = "";
        $hide2='style="display:none;"';
    }else{
        $hide1='style="display:none;"';
    }
};


?>

<main class="container">

    <section class="cards">
        <img class="card-img" src="/make-team/img/<?=$image?>" alt="">
        <div class="card-content">
            <h1 class="card-title"><?=$team_name?></h1>
            <p class="card-goal">目標：　<?=$goal?></p>
            <p class="card-text"><?=$t_comment?></p>

                <!--loginしたら表示-->
                <?=$team_mission?>

        </div>
        <div class="card-link">
            <!--参加したら表示-->
            <form method="post" action="/select/team/insert_team.php">
                <input type="hidden" class="user_id" name="user_id" value="<?=$user_id?>">
                <input type="hidden" class="team_id" name="team_id" value="<?=$team_id?>">
                <input type="hidden" class="status" name="status" value="0">
                <button type="submit" class="btn btn-group-justified btn-warning" id="join-button" <?=$hide1?>>参加する</button>
            </form>
            <!--日参加時に表示表示-->
            <form method="post" action="/select/team/insert_team.php">
                <input type="hidden" class="user_id" name="user_id" value="<?=$user_id?>">
                <input type="hidden" class="team_id" name="team_id" value="<?=$team_id?>">
                <input type="hidden" class="status" name="status" value="1">
                <a href="/mission?team_id=<?=$team_id?>" class="btn" <?=$hide2?>>Missionを作成する</a>
                <button type="submit" class="btn" id="quit-button" <?=$hide2?>>退会する</button>
            </form>
        </div>
    </section>

</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>


</html>