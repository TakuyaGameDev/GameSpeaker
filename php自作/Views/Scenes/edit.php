
<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // 編集対象のデータ抽出(GETメソッドで取得)
    $editIndex = $controller->getGameIndexById("GET");
    $errMsg = "";
    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if(!empty($_SESSION['edit']))
        {
            $post = $_SESSION['edit'];
            $name = $post['name'];
            $junre = $post['junre'];
            $value = $post['value'];
            
            $intro = $post['intro'];
            
        }
        else
        {
            foreach($editIndex as $index)
            {
                $name = $index['name'];
                $junre = $index['junre'];
                $value = $index['value'];
                $intro = $index['intro'];
            }
            $errMsg = "";
        }
    }
    else
    {
        if(isset($_POST['returnBtn']))
        {
            header('Location: Main.php');
        }
        $post = filter_input_array(INPUT_POST,$_POST);
        $name = $post['name'];
        $junre = $post['junre'];
        $value = $post['value'];
        $intro = nl2br($post['intro']);

        // バリデーション
        if(strlen($intro) < 100 || strlen($intro) > 500)
        {
            $_SESSION['edit'] = $post;
            $errMsg = "コメントは100文字以上500文字以内でご入力下さい";
        }
        if(strlen($intro) <= 0)
        {
            $_SESSION['edit'] = $post;
            $errMsg = "コメントは必須入力です";
        }

        if($errMsg === "")
        {
            if(isset($_POST['confirm']))
            {
                $_SESSION['edit'] = $post;
                $id = $controller->getter_Get("id");
                $user_id = $controller->getter_Get("user_id");
                header('Location: Confirm_edit.php?id='.$id.'&user_id='.$user_id);
            }
        }
    }
?>



<body>
<div class = "Edit">
        <h1 align="center">編集</h1>
        <form action="" method="POST">
            <div class = "inputArea">
                <div class = "name_junre" align="center">
                    <p>ジャンル</p>
                    <input type = "text" name = "junre" placeholder="ジャンル名" value = <?php echo $junre?> readonly>
                </div>
                <div class = "name_game" align="center">
                    <p>ゲーム名</p>
                    <input type = "text" name = "name" placeholder="ゲーム名" value = <?php echo $name?> readonly>
                </div>
                <div class = "value" align="center">
                    <p>評価値</p>
                    <select id = "valueOption" name = "value" value = <?php echo $value?>>
                        <option value = "0">0</option>
                        <option value = "1">1</option>
                        <option value = "2">2</option>
                        <option value = "3">3</option>
                        <option value = "4">4</option>
                        <option value = "5">5</option>
                    </select>
                </div>
                <div class = "comment" align="center">
                    <p>コメント</p>
                    <?php if($errMsg !== ""):?>
                        <p id = "err"><?php echo $errMsg?></p>
                    <?php endif;?>
                    <div class = "comment" align="center">
                    <textarea name = "intro" cols="30" rows="10" wrap="hard" id = "intro"><?php echo $intro?></textarea>
                    <p id = "strCounter"></p>
                    </div>
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