
<?php include('header.php');?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    unset($_SESSION['edit']);
    // コントローラーのインスタンス
    $controller = new Controller();
    // 自分のユーザーIDで一覧取得
    $indexes = $controller->getGameIndexByUserId("GET");
    // 投稿数
    $historiesNum = count($indexes);
?>

<body>
    <div class ="histories">
        <h1 align="center">投稿履歴</h1>
        <?php if($historiesNum > 0){?>
        <div class = "boxArea">
            <?php foreach($indexes as $index):?>
                    <div class = "gameBox">
                        <h2 align="center">ゲーム名 : <span><?php echo $index['name']?></span></h2>
                        <h2 align="center">ジャンル名 : <span><?php echo $index['junre']?></span></h2>
                        <h2 align="center">評価 : <span><?php echo $index['value']?></span></h2>
                        <div class = "commentBox">
                            <h1 align="center"><?php echo nl2br($index['intro'])?></h1>
                        </div>
                        <div class = "edit_deleteArea" style = "margin-left:10px;margin-top:10px;">
                            <a href = "edit.php?user_id=<?php echo $index['user_id'];?>&id=<?php echo $index['id'];?>" style = "font-size:24px; margin-right:20px;">編集</a>
                            <a href = "Confirm_delete.php?user_id=<?php echo $index['user_id'];?>&id=<?php echo $index['id'];?>" style = "font-size:24px;">削除</a>
                        </div>
                    </div>
            <?php endforeach;?>
        </div>
        <?php }else{?>
            <p align="center" style="font-size:24px;">投稿がありません</p>
        <?php }?>
        <div class = "btnArea">
            <a href = "Main.php" style="font-size:24px;">戻る</a>
        </div>
    </div>
</body>