<!-- ヘッダーのインクルード !-->
<?php include('header.php');?>

<?php
require_once(ROOT_PATH."Controllers/Controller.php");
$controller = new Controller();

$name = "";
$junre = "";
// 表示する最大数
$indexLimNum = 2;
// ゲーム名のみで検索をかけた場合
if($controller->getter_Get("name") != 0 && $controller->getter_Get("junre") == 0)
{
    $name = $controller->getter_Get("name");
    // 最新投稿数
    $gameCount = count($controller->getGameIndexByNameOnly());
    $indexCount = (floor($gameCount / $indexLimNum)) + (floor($gameCount % $indexLimNum));
    // ゲーム一覧
    $games = $controller->getGameIndexByNameOnlyPerPage();
}
// ゲームジャンルのみで検索をかけた場合
if($controller->getter_Get("junre") != 0 && $controller->getter_Get("name") == 0)
{
    $junre = $controller->getter_Get("junre");
    // 最新投稿数
    $gameCount = count($controller->getGameIndexByJunre($junre));
    $indexCount = (floor($gameCount / $indexLimNum)) + (floor($gameCount % $indexLimNum));
    // ゲーム一覧
    $games = $controller->getGameIndexPageByJunre($junre);
}
if($controller->getter_Get("name") != 0 && $controller->getter_Get("junre") != 0)
{
    $junre = $controller->getter_Get("junre");
    $name = $controller->getter_Get("name");
    // 最新投稿数
    $gameCount = count($controller->getGameIndexByNameAndJunre());
    $indexCount = (floor($gameCount / $indexLimNum)) + (floor($gameCount % $indexLimNum));
    // ゲーム一覧
    $games = $controller->getGameIndexNameAndJunrePerPage($junre);
}
?>

<body>
    <div class = "search">
    <div class = "searchIndex">
    <?php if($name != ""):?>
        <h1>ゲーム名で検索 : <?php echo $name;?></h1>
    <?php endif;?>
    <?php if($junre != ""):?>
        <h1>ゲームジャンルで検索 : <?php echo $junre; ?></h1>
    <?php endif;?>
    
    <p>
        <?php if($name != "" && $junre != ""):?>
            <?php echo count($controller->getGameIndexByNameAndJunre());?> 件ヒット
        <?php endif;?>
        <?php if($junre == "" && $name != ""):?>
            <?php echo count($controller->getGameIndexByNameOnly());?> 件ヒット
        <?php endif;?>
        <?php if($junre != "" && $name == ""):?>
            <?php echo count($controller->getGameIndexByJunre($junre));?> 件ヒット
        <?php endif;?>
    </p>
    </div>
    <div class = "indexBox">
        <?php if($gameCount <= 0):?>
            <h1>検索結果はありませんでした.....</h1>
        <?php endif;?>
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
                if($name != "" && $junre == "")
                {
                    echo "<a href='?page=".$i."&name=".$name."'>".($i+1)."</a>";
                }
                if($name == "" && $junre != "")
                {
                    echo "<a href='?page=".$i."&junre=".$junre."'>".($i+1)."</a>";
                }
                if($name != "" && $junre != "")
                {
                    echo "<a href='?page=".$i."&name=".$name."&junre=".$junre."'>".($i+1)."</a>";
                }
            }
            else
            {
                if($name != "" && $junre == "")
                {
                    echo "<a href='?page=".$i."&name=".$name."'>".($i+1)."</a>";
                }
                if($name == "" && $junre != "")
                {
                    echo "<a href='?page=".$i."&junre=".$junre."'>".($i+1)."</a>";
                }
                if($name != "" && $junre != "")
                {
                    echo "<a href='?page=".$i."&name=".$name."&junre=".$junre."'>".($i+1)."</a>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
    <div class = "btnArea">
        <a href = "Main.php?user_id=<?php echo $user_id;?>" style="font-size:24px; text-decoration:none; color:#000000;">戻る</a>
    </div>
    </div>
    </div>
    <div class = "jumpTopBtn">
        <a href = "#">トップへ</a>
    </div>  
</body>