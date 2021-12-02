<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // データの消去
    // ユーザー情報まで消去するのかを決定
    // ユーザー情報まで消去するのであればtrueに
    // ユーザー情報までは削除しないのであればfalse
    $flg = $_SESSION['delUserFlg'];
    echo $flg;
    // ユーザーまで消去するか
    if($flg == 1)
    {
        // 削除対象のユーザーの「いいね！」情報の削除
        $controller->deleteFavByUserId();
        // 削除対象のユーザーの閲覧履歴の削除
        $controller->deleteBrowsingHisByUserId();
        // ゲームデータの消去
        $controller->deleteGameInfoByUserId();
        // チャットデータの削除
        $controller->deleteChatData();
        // ユーザーデータの消去
        $controller->deleteUserById();
    }
    // ゲーム情報だけを消去する場合
    else
    {
        // ゲームデータの削除
        $controller->deleteGameInfoById();
    }
    $user_id = $controller->getter_Get('user_id');
?>
<script>
    var n = 5;
    setInterval(function () {
    var msg = n + "秒後にホーム画面へ移行します";
    $('#PassTimeArea').text(msg);
    n--;
    var flg = <?php echo $flg;?>;
    if(n < 0)
    {
        if(flg == 0)
        {
            <?php unset($_SESSION['delUserFlg']);?>
            window.location.href = "Main.php?user_id=<?php echo $user_id;?>";
            
        }
        else
        {
            <?php unset($_SESSION['delUserFlg']);?>
            window.location.href = "LogIn.php";
        }
    }
    }, 1000)

</script>
<body>
    <div class = "Delete">
        <h1 style="font-size:24px;" align="center">削除しました</p>
        <p id = PassTimeArea></p>
    </div>
</body>

