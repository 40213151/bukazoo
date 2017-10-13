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

    <link rel="stylesheet" href="./css/style.css">

    <!-- unique scripts -->

</head>

<body>

<!-- loginしていたら下記を読み込む -->

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/header.php');
?>
<?php
// include($_SERVER['DOCUMENT_ROOT'] .'/functions.php');
// chkSSID();
$id = $_SESSION["id"];

//SQL実行
$stmt = $pdo->prepare("SELECT * FROM bukazoo_team_table");
$status = $stmt->execute();

//SQL処理エラー
$view="";
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}else{
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
//        $view .= '<a href="team/?team_id='.$result["id"].'" class="each-cards-links col-xs-12">';
//        $view .='<div class="">';
//        $view .= '<div class="card">';
//        $view .= '<p class="daytime">部活名：'.$result["team_name"].'</p>';
//        $view .= '<p class="task">目標：'.$result["goal"].'km</p>';
//        $view .= '<div class="team">';
//        $view .= '<p class="comment">コメント：'.$result["t_comment"].'</p>';
//        $view .= '<p class="member">定員：'.$result["member_num"].'名!</p>';
//        $view .= '<p class="status">応募：残り2名！</p>';
//        $view .= '</div>';
//        $view .= '</div>';
//        $view .= '</div>';
//        $view .= '</a>';
        $view .= '<section class="cards">';
        $view .= '<img class="card-img" src="/make-team/img/'.h($result["image"]).'" alt="">';
        $view .= '<div class="card-content">';
        $view .= '<h1 class="card-title">'.h($result["team_name"]).'</h1>';
        $view .= '<p class="card-text">'.h(mb_strimwidth($result["t_comment"], 0, 168, '...')).'</p>';
        $view .= '</div>';
        $view .= '<div class="card-link">';
        $view .= '<a href="team/?team_id='.h($result["id"]).'" class="go-to-detail">go to detail</a>';
        if($id == $result["captain"]){
            $view .= '<a href="/make-team/edit/?team_id='.h($result["id"]).'" class="link-edit">edit team</a>';
        };
        $view .= '</div>';
        $view .= '</section>';
    };
};
?>

<main class="container">

    <p class="team-lists">Team Lists</p>

    <div class="row">
        <?php
        echo $view;
        ?>
    </div>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/footer.php');
?>

</body>

</html>