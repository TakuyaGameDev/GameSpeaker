<!-- ヘッダーのインクルード !-->
<?php include('header.php');?>

<?php
require_once(ROOT_PATH."Controllers/Controller.php");
$controller = new Controller();
// $_GETからのuser_idの取得
$user_id = $controller->getter_Get("user_id");
// $_GETからのfavJunreの取得
$favJunre = $controller->getter_Get("favJunre");
$gameCount = count($controller->getGameIndexByJunre($favJunre));

$favGames = $controller->getGameIndexPageByJunre($favJunre);

$indexLimNum = 2;
$indexCount = (floor($gameCount/$indexLimNum) + floor($gameCount%$indexLimNum));
?>

<body>
    <div class = "newIndex">
        <h1>新着一覧</h1>
        <div class = "indexBox">
            <?php for($num = 0;$num < $indexLimNum;$num++):?>
                <?php if(!empty($favGames[$num])):?>
                <div class = "gameBox">
                    <h2 align="center">ゲーム名 : <span><?php echo $favGames[$num]['name']?></span></h2>
                    <h2 align="center">ジャンル名 : <span><?php echo $favGames[$num]['junre']?></span></h2>
                    <div class = "box">
                        <h2>評価 : <span><?php echo $favGames[$num]['value']?></span></h2>
                        <h2>投稿者ID : <span><?php echo $favGames[$num]['user_id']?></span></h2>
                    </div>
                    <div class = "commentBox">
                        <h1 align="center"><?php echo nl2br($favGames[$num]['intro'])?></h1>
                    </div>
                    <a href = "detail.php?name=<?php echo $favGames[$num]['name'];?>&user_id=<?php echo $favGames[$num]['user_id'];?>&junre=<?php echo $favGames[$num]['junre'];?>" style="color:#000000;font-size:24px;">詳細</a>
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
                echo "<a href='?page=".$i."&favJunre=".$favJunre."'>".($i+1)."</a>";
            }
            else
            {
                echo "<a href='?page=".$i."&favJunre=".$favJunre."'>".($i+1)."</a>";
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