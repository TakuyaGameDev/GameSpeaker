
<!-- ヘッダーのインクルード !-->
<?php include('header.php');?>

<?php
require_once(ROOT_PATH."Controllers/Controller.php");
$controller = new Controller();
// $_GETからのuser_idの取得
$user_id = $controller->getter_Get("user_id");
// 最近の投稿の取得
$games = $controller->getRecentlyGamePageIndex();
// 表示する最大数
$indexLimNum = 2;
// 最新投稿数
$gameCount = count($controller->getRecentlyGamesInfo());
$indexCount = (floor($gameCount / $indexLimNum)) + (floor($gameCount % $indexLimNum));
?>

<body>
    <div class = "newIndex">
        <h1>新着一覧</h1>
        <div class = "indexBox">
            <?php for($num = 0;$num < $indexLimNum;$num++):?>
                <?php if(!empty($games[$num])):?>
                    <div class = "gameBox">
                        <h2 align="center">ゲーム名 : <span><?php echo $games[$num]['name']?></span></h2>
                        <h2 align="center">ジャンル名 : <span><?php echo $games[$num]['junre']?></span></h2>
                        <div class = "box">
                            <h2>評価 : <span><?php echo $games[$num]['value']?></span></h2>
                            <h2>投稿者ID : <span><?php echo $games[$num]['user_id']?></span></h2>
                        </div>
                        <div class = "commentBox">
                            <h1 align="center"><?php echo nl2br($games[$num]['intro'])?></h1>
                        </div>
                        <a href = "detail.php?name=<?php echo $games[$num]['name'];?>&user_id=<?php echo $games[$num]['user_id'];?>&junre=<?php echo $games[$num]['junre'];?>" style="color:#000000;font-size:24px;">詳細</a>
                    </div>
                <?php endif;?>
            <?php endfor;?>
        </div>
        <div id = 'paging'>
        <?php
        for($i = 0;$i < $indexCount;$i++)
        {
            echo "<div>";
            if(isset($_GET['page']) && ($_GET['page'] == $i))
            {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
            else
            {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
            echo "</div>";
        }
        ?>
        </div>
    <div class = "btnArea">
        <a href = "Main.php?user_id=<?php echo $user_id;?>" style="font-size:24px; text-decoration:none; color:#000000;">戻る</a>
    </div>
    </div>
    <div class = "jumpTopBtn">
        <a href = "#">トップへ</a>
    </div>  
</body>