
<?php
session_start();
if(isset($_SESSION['form']))
{
    $post = $_SESSION['form'];
    // ユーザーIDの格納
    $user_id = $post['chat_id'];
}
else
{
    $user_id = $_GET['user_id'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Main</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/js/process.js"></script>
<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
    <body style="background-color:#d0d0d0">
        <div class = "Header1">
            <div class = "title"></div>
            <div class = "logo"></div>
            <p class = "name"><?php echo $user_id?>さん！ようこそ!</p>
            <p class = "name_id">ID:<?php echo $user_id?></p>
            <a class = "logout" href = "LogIn.php">ログアウト</a>
        </div>
        <div class = "Header2">
            <div class = "newer">
                <a href = "#New">新着</a>
            </div>
            <div class = "anyway">
                <a href = "#AnyWay">とりあえず</a>
            </div>
            <div class = "search">
                <a href = "#Search">検索</a>
            </div>
        </div>
        <?php if($user_id !== "00000000"):?>
            <div class = "menuBoxBtn">
                <h1 stype="font-weight:bold;">←</h1>
            </div>
            <div class = "menuBox">
                <a href="Contribute.php?user_id=<?php echo $user_id;?>">コメント投稿</a>
                <a href="Histories.php?user_id=<?php echo $user_id;?>">投稿履歴</a>
                <a href="edit_user.php?user_id=<?php echo $user_id?>">アカウント編集</a>
                <a href="input_deleteUser.php?user_id=<?php echo $user_id?>">アカウント削除</a>
            </div>
        <?php endif;?>
    </body>
</html>