<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // 削除対象のゲーム情報の取得
    $delIndex = $controller->getGameIndexById("GET");

    $id = $controller->getter_Get("id");
    $user_id = $controller->getter_Get("user_id");
    if(!isset($_SESSION['delUserFlg']))
    {
        // ユーザー情報までも削除するフラグを0に
        $_SESSION['delUserFlg'] = 0;
    }
?>

<?php if(!$_SESSION['delUserFlg']){?>
<body>
<div class = "detail">
        <h1 align="center">削除確認</h1>
        <h1 align="center" style = "color:#ff0000;">この投稿を削除しますか？</h1>
        <div class = "detailBox">
            <?php foreach($delIndex as $del):?>
                <h2>投稿者ID : <span><?php echo $del['user_id'];?></span></h2>
                <h2>ゲーム名 : <span><?php echo $del['name'];?></span></h2>
                <h2>ジャンル名 : <span><?php echo $del['junre'];?></span></h2>
                <h2>評価 : <span><?php echo $del['value'];?></span></h2>
                <div class = "commentBox">
                    <h1 style="font-size:24px;"><?php echo nl2br($del['intro'])?></h1>
                </div>
        </div>
        <?php endforeach;?>
        <div class = "btnArea">
            <a class = "deleteBtn" href = "delete.php?user_id=<?php echo $user_id?>&id=<?php echo $id?>" style = "margin-right:100px;" onclick="setStart();">削除</a>
            <a href = "Histories.php?user_id=<?php echo $user_id?>">戻る</a>
        </div>
    </div>
</body>
<?php }else{?>
    <body>
        <div class = "detail_user">
                <h1 align="center">アカウント削除確認</h1>
                <h1 align="center" style = "color:#ff0000;">本当に削除しますか？</h1>
                <p class = "confirmStr" align="center" style="color:#ff0000; font-size:24px;">一度リセットすると投稿履歴、chatIDの両方がリセットされます。ご注意下さい</p>
            <div class = "btnArea">
                <a class = "deleteBtn" href = "delete.php?user_id=<?php echo $user_id?>" style = "margin-right:100px;" onclick="setStart();">削除</a>
                <a href = "Main.php?user_id=<?php echo $user_id?>">戻る</a>
            </div>
        </div>
    </body>
<?php } ?>