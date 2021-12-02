
<?php include('header.php');?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // Main画面からgetしてきたゲーム名から取ってきた1ゲーム情報
    $details = $controller->getGameIndexByName("GET");
    $post_id = 0;
    foreach($details as $detail)
    {
        $post_id = $detail['id'];
    }
    // 自分のユーザーIDの格納
    $myId = $_SESSION['form']['chat_id'];
    if($myId != "00000000")
    {
        // 閲覧履歴の更新
        $controller->registrateBrowsingHis($myId);
    }
    // 投稿者ユーザーIDの取得
    $user_id = $controller->getter_Get('user_id');
    // 投稿者IDと自分のIDが同じならば「いいね」ボタンは押させないフラグ
    // false : ボタンを非アクティブに
    // true : ボタンをアクティブに
    $favPermitFlg = true;
    if($myId === $user_id)
    {
        $favPermitFlg = false;
    }
    if(isset($_POST['fav']))
    {
        $controller->updateFav($myId,$post_id);
    }
?>

<body>
    <form action = "" method = "POST">
        <div class = "detail">
        <h1 align="center">詳細</h1>
        <?php foreach($details as $detail):?>
            <div class = "detailBox">
                    <h2>投稿者ID : <span><?php echo $detail['user_id'];?></span></h2>
                    <h2>ゲーム名 : <span><?php echo $detail['name'];?></span></h2>
                    <h2>ジャンル名 : <span><?php echo $detail['junre'];?></span></h2>
                    <h2>評価 : <span><?php echo $detail['value'];?></span></h2>
                    <div class = "commentBox">
                        <h1 style="font-size:24px;"><?php echo nl2br($detail['intro'])?></h1>
                    </div>
                    <?php if($myId != "00000000"):?>
                    <div class = "favArea">
                        <?php if($favPermitFlg):?>
                            <button type = "submit" id = "favBtn" name = "fav">いいね！</button>
                        <?php endif;?>
                        <div class = "favCountBox">
                            <p id = "favStr">いいね！の数: <?php echo count($controller->getFavIndex($post_id))?></p>
                            <div id = "favDetail">
                                <?php foreach($controller->getFavIndex($post_id) as $fav):?>
                                    <p><?php echo $fav['user_id'];?></p>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
            </div>
    </form>
        <?php if($myId != "00000000" && $myId != $user_id):?>
            <div class = "contact">
                <p align="center"><a href = "chat.php?user_id=<?php echo $myId;?>&postUser_id=<?php echo $user_id;?>&name=<?php echo $detail['name']?>&junre=<?php echo $detail['junre']?>" style="text-decoration:none;font-size:28px;"><?php echo $detail['user_id'];?> さんとチャットをする</a></p>
            </div>
        <?php endif;?>
            <?php endforeach;?>
        <div class = "btnArea">
            <a href = "Main.php?user_id=<?php echo $myId;?>">戻る</a>
        </div>
    </div>
</body>