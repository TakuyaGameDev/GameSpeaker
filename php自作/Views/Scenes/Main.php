
<!-- ヘッダーのインクルード !-->
<?php include('header.php');?>

<?php
require_once(ROOT_PATH."Controllers/Controller.php");

$controller = new Controller();

$user_id = $_SESSION['form']['chat_id'];

unset($_SESSION['userEdit']);
// 最近の投稿の取得
$games = $controller->getRecentlyGamesInfo();
// 新着ゲームの掲載最大数
$newerGamesLimNum = 6;
$errMsg = "";
if($user_id !== "00000000")
{
    // ゲームジャンル名配列
    $junreArray = ["アクション","ホラー","シューティング","アクションシューティング","TPS","FPS"];
    // ランダムにジャンル名を決めるための配列番号
    $arrNo = 0;
    unset($_SESSION['contribute']);
    unset($_SESSION['edit']);

    // 閲覧履歴の取得(user_idを元にjunreを取得)
    $histories = $controller->getHistoryById($user_id);

    // 「とりあえず」の最大掲載数(3でもいい気がする)
    $anymwyGamesLimNum = $newerGamesLimNum;

    // ユーザー毎のお気に入りゲームジャンル名
    $favJunre = "";
    $browseCount = 0;

    foreach($histories as $history)
    {
        if($history['count'] > $browseCount)
        {
            $favJunre = $history['junre'];
            $browseCount = $history['count'];
        }
    }
    // 一番見ているゲームのジャンル一覧を取得
    $favGames = $controller->getGameIndexByJunre($favJunre);

    // まだ投稿を見ていない場合は0なので「とりあえず」には何も表示されないので
    // ここで表示するゲームジャンルをランダムで決定
    if(count($favGames) <= 0)
    {
        // ジャンル名番号をランダムに生成
        $arrNo = mt_rand(0,count($junreArray)-1);
        // 「とりあえず」に表示する投稿ゲームのジャンルの決定
        $favJunre = $junreArray[$arrNo];
            // 一番見ているゲームのジャンル一覧を取得
        $favGames = $controller->getGameIndexByJunre($favJunre);
    }
}
    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {

    }
    else
    {
        $post = filter_input_array(INPUT_POST,$_POST);

        if(isset($_POST["exeBtn"]))
        {
            if($post['name'] == "" || $post['junre'] == "")
            {
                $errMsg = "ゲーム名かゲームジャンルを入力して下さい。";
            }
            if($post['name'] != "" && $post['junre'] != "")
            {
                header('Location: search_index.php?name='.$post['name']."&junre=".$post['junre']);
                exit();
            }
            // issetで判定すればよいか
            if($post['name'] != "")
            {
                header('Location: search_index.php?name='.$post['name']);
                exit();
            }
            else if($post['junre'] != "")
            {
                header('Location: search_index.php?junre='.$post['junre']);
                exit();
            }
        }
    }
?>

<body>
    <section class = "Main">
        <h1>新着</h1>
        <section id = "New">
        <?php for($num = 0;$num < $newerGamesLimNum; $num++):?>
            <?php if(!empty($games[$num])):?>
                
                <div class = "gameBox">
                    <h2 align="center">ゲーム名 : <span><?php echo $games[$num]['name']?></span></h2>
                    <h2 align="center">ジャンル名 : <span><?php echo $games[$num]['junre']?></span></h2>
                    <div class = "box">
                        <h2>評価 : <span><?php echo $games[$num]['value']?></span></h2>
                        <h2>投稿者ID : <span><?php echo $games[$num]['user_id']?></span></h2>
                    </div>
                    <div class = "commentBox">
                        <!-- 40文字以上になったら...を表示 -->
                        <!-- detailに行くと全表示 -->
                        <h1 align="center"><?php echo mb_strimwidth(nl2br($games[$num]['intro']),0, 40, '…', 'UTF-8');?></h1>
                    </div>
                    
                    <a href = "detail.php?name=<?php echo $games[$num]['name'];?>&user_id=<?php echo $games[$num]['user_id'];?>&junre=<?php echo $games[$num]['junre'];?>" style="color:#000000;font-size:24px;">詳細</a>
                </div>
            <?php endif;?>
        <?php endfor;?>
        </section>
        <a class = "findAny" href = "newIndex.php?user_id=<?php echo $user_id;?>">もっと見る</a>
        <?php if($user_id !== "00000000"):?>
        <h1>とりあえず</h1>
        <section id = "AnyWay">
        <?php for($num = 0;$num < $anymwyGamesLimNum;$num++):?>
            <?php if(!empty($favGames[$num])):?>
                <div class = "gameBox">
                    <h2 align="center">ゲーム名 : <span><?php echo $favGames[$num]['name']?></span></h2>
                    <h2 align="center">ジャンル名 : <span><?php echo $favGames[$num]['junre']?></span></h2>
                    <div class = "box">
                        <h2>評価 : <span><?php echo $favGames[$num]['value']?></span></h2>
                        <h2>投稿者ID : <span><?php echo $favGames[$num]['user_id']?></span></h2>
                    </div>
                    <div class = "commentBox">
                        <!-- 40文字以上になったら...を表示 -->
                        <!-- detailに行くと全表示 -->
                        <h1 align="center"><?php echo mb_strimwidth(nl2br($favGames[$num]['intro']),0, 40, '…', 'UTF-8');?></h1>
                    </div>
                    <a href = "detail.php?name=<?php echo $favGames[$num]['name'];?>&user_id=<?php echo $favGames[$num]['user_id'];?>&junre=<?php echo $favGames[$num]['junre'];?>" style="color:#000000;font-size:24px;">詳細</a>
                </div>
            <?php endif;?>
        <?php endfor;?>
        </section>
        <a class = "findAny" href = "AnywayIndex.php?user_id=<?php echo $user_id;?>&favJunre=<?php echo $favJunre;?>">もっと見る</a>
        <?php endif;?>
        <h1>検索</h1>
        <form action="" method = "POST">
            <section id = "Search">
                    <?php if($errMsg != ""):?>
                        <p id = "err">
                            <?php echo $errMsg;?>
                        </p>
                    <?php endif;?>
                <div class = "contents">
                    <span>ゲームジャンルで検索 : <input class = "searchInput" type = "text" placeholder="ゲームジャンル" name = "junre"></span>
                    <span>&emsp;&emsp;&emsp;ゲーム名で検索 : <input class = "searchInput" type = "text" placeholder="ゲーム名" name = "name"></span>
                    <input class = "exeBtn" type = "submit" name = "exeBtn" value = "実行">
                </div>
            </section>
        </form>
        <div class = "jumpTopBtn">
            <a href = "#">トップへ</a>
        </div>
    </section>
</body>

