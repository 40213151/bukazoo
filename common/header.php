<?php
include($_SERVER['DOCUMENT_ROOT'] .'/functions.php');
chkSSID();

if(isset($_SESSION["id"])){
    $id = $_SESSION["id"];
}

$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM bukazoo_user_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

$user_id="";

if($status==false){
    queryError($stmt);
}else{
    $result = $stmt->fetch();
    $user_id = $result["user_id"];
    $user_img = $result["image"];
};

?>

<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#patern03">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">bukaƵoo</span>
                <a href="/mypage" class="navbar-brand" id="header-user-name"><?=$user_id?></a>
            </div>

            <div id="patern03" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/mypage">mypage</a></li>
                    <li><a href="/make-team">create team</a></li>
                    <li><a href="/select">team lists</a></li>
                    <li><a href="/common/logout.php">logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

</header>