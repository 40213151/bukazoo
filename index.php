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
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/validationEngine.jquery.css">

<!-- unique scripts -->
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-ja.js"></script>
<script>
      $(function(){
        jQuery("#form_1").validationEngine();
      });
    </script>

</head>

<body>

<div class="jumbotron">
  <main class="container">
    <!--説明書き-->
    <div class="col-md-6 left-discription">
      <div class="bukazoo">
        <h1>bukaZoo!</h1>
      </div>
      <div>
        <p class="catch-copy">今日だけやる。その繰り返し。<br>
            みんなやってる。私もやれる。</p>
      </div>
      <div>
        <a class="button details" href="/introduction">もっと詳しく</a>
      </div>
    </div>
    <!--login or　新規登録-->
    <div class="col-md-4 signup" id="signup">
    <!--<div class="col-md-4 signup" style="display: none;">-->
      <button class="tab" id="tab1" disabled="disabled">新規登録</button>
      <button class="tab" id="tab2">ログイン</button>
      <div class="right-form">
        <form method="post" action="insert.php" id="form_1">
            <input type="text" class="form-control validate[required]" name="name" placeholder="名前">
            <input type="text" class="form-control validate[required]" name="user_id" placeholder="ユーザー名">
            <input type="text" class="form-control validate[custom[email]]" name="email" placeholder="メールアドレス">
            <input type="password" class="form-control validate[required]" name="password" placeholder="パスワード">
            <input type="password" class="form-control validate[required]" name="cnfrm_password" placeholder="パスワード確認入力"> 
            <div class="discription">
              以下の登録ボタンクリックにより、<a class="explanation" href="">利用規約</a>及び<a class="explanation" href="">個人情報の取り扱い</a>に関する要項に同意したものとします。
            </div>
            <button type="submit" class="btn btn-info btn-block register" id="btn_submit">無料で登録する</button>
<!--            <div>OR</div>-->
<!--            <div>SNSアカウントで登録</div>-->
<!--            <div class="sns">-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/facebook.png" alt="facebook"></a>-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/twitter.png" alt="twitter"></a>-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/googleplus.png" alt="googleplus"></a>-->
<!--            </div>-->
        </form>
      </div>
    </div>
     <div class="col-md-4 signin" id="signin"style="display: none;">
     <!--<div class="col-md-4 signin">-->
      <button class="tab" id="tab3">新規登録</button>
      <button class="tab" id="tab4" disabled="disabled">ログイン</button>
      <div class="right-form">
        <form method="post" action="login_act.php">
            <input type="text" class="form-control" name="user_id" placeholder="ユーザー名">
            <input type="password" class="form-control" name="inputPassword" id="password" placeholder="パスワード">
            <div class="vertical-align">
              <label for="checkbox1"><input type="checkbox" id="checkbox1">パスワードを表示する</label>
            </div>
            <button type="submit" class="btn btn-info btn-block login">LOGIN</button>
<!--            <div>OR</div>-->
<!--            <div>SNSアカウントでLOGIN</div>-->
<!--            <div class="sns">-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/facebook.png" alt="facebook"></a>-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/twitter.png" alt="twitter"></a>-->
<!--              <a href="" class="eachsns"><img src="/img/Without Border/googleplus.png" alt="googleplus"></a>-->
<!--            </div>-->
        </form>
      </div>
    </div>
  </main>
</div>

<script src="/js/functions.js"></script>

</body>


</html>