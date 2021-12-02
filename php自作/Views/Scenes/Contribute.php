
<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // エラーメッセージ格納用変数
    $errMsg = ["","",""];
    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if(!empty($_SESSION['contribute']))
        {
            $post = $_SESSION['contribute'];
            $name = $post['name'];
            $junre = $post['junre'];
            $value = $post['value'];
            $intro = $post['intro'];
        }
        else
        {
            $name = "";
            $junre = "";
            $value = "";
            $intro = "";
            $errMsg = ["","",""];
        }
    }
    else
    {
        if(isset($_POST['returnBtn']))
        {
            unset($_SESSION['contribute']);
            $id = $controller->getter_Get("user_id");
            header('Location: Main.php?user_id='.$id);
        }
        // バリデーション
        $post = filter_input_array(INPUT_POST,$_POST);
        $name = $post['name'];
        $junre = $post['junre'];
        $value = $post['value'];
        $intro = $post['intro'];
        // ゲームの投稿を特定のnameで取得
        $gameInfo = $controller->getGameIndexByName("POST");
        if(mb_strlen($junre) <= 0)
        {
            $errMsg[0] = "ゲームジャンルは必須入力です";
        }
        if(mb_strlen($junre) > 20)
        {
            $errMsg[0] = "ゲームジャンルは20文字以内で入力下さい";
        }
        if(mb_strlen($name) <= 0)
        {
            $errMsg[1] = "ゲーム名は必須入力です";
        }
        if(mb_strlen($name) > 20)
        {
            $errMsg[1] = "ゲーム名は20文字以内で入力下さい";
        }
        // 既に投稿済みのタイトルかのチェック
        if($gameInfo)
        {
            $errMsg[1] = "このゲームタイトルは投稿済みです";
        }
        if(mb_strlen($intro) <= 0)
        {
            $errMsg[2] = "コメントは必須入力です";
        }
        if(mb_strlen($intro) < 100 || mb_strlen($intro) > 500)
        {
            $errMsg[2] = "コメントは100文字以上500文字以内で入力下さい";
        }
        if($errMsg[0] === "" && $errMsg[1] === "" && $errMsg[2] === "")
        {
            if(isset($_POST['confirm']))
            {
                $_SESSION['contribute'] = $post;
                $id = $controller->getter_Get("user_id");
                header('Location: Confirm_contribute.php?user_id='.$id);
            }
        }
    }
?>

<body>
    <div class = "Contribute">
        <h1 align="center">投稿</h1>
        <form action="" method="POST">
            <div class = "inputArea">
                <div class = "name_junre" align="center">
                    <p>ジャンル</p>
                    <?php if($errMsg[0] !== ""):?>
                        <p id = "err"><?php echo $errMsg[0]?></p>
                    <?php endif;?>
                    <input type = "text" name = "junre" placeholder="ジャンル名" value = "<?php echo $junre?>">
                </div>
                <div class = "name_game" align="center">
                    <p>ゲーム名</p>
                    <?php if($errMsg[1] !== ""):?>
                        <p id = "err"><?php echo $errMsg[1]?></p>
                    <?php endif;?>
                    <input type = "text" name = "name" placeholder="ゲーム名" value = "<?php echo $name?>">
                </div>
                <div class = "value" align="center">
                    <p>評価値</p>
                    <!-- バリデーションエラーになるとこれだけが0リセットになるので避けたい....どうやって....-->
                    <select id = "valueOption" name = "value" value = <?php echo $value?>>
                        <option value = "0">0</option>
                        <option value = "1">1</option>
                        <option value = "2">2</option>
                        <option value = "3">3</option>
                        <option value = "4">4</option>
                        <option value = "5">5</option>
                    </select>
                </div>
                <p>コメント</p>
                <div class = "comment" align="center">
                    <?php if($errMsg[2] !== ""):?>
                        <p id = "err"><?php echo $errMsg[2]?></p>
                    <?php endif;?>
                    <textarea id = "intro" name = "intro" align="center"><?php echo $intro?></textarea>
                    <p id = "strCounter"></p>
                </div>
            </div>
            <div class = "btnArea" align="center">
                <div class = "exeBtn">
                    <input type = "submit" name = "confirm" value = "確認画面へ" style="font-size:24px;">
                </div>
                <div class = "rtnBtn">
                    <input class ="rtnBtn" type = "submit" name = "returnBtn" value = "戻る" style="font-size:24px;">
                </div>
            </div>
        </form>
    </div>
</body>