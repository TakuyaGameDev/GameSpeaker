<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    $password = "";
    $chat_id = "";
    $errMsg = ["","",""];
    // コントローラーのインスタンス
    $controller = new Controller();
    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if(!empty($_SESSION['delete']))
        {
            $post = $_SESSION['delete'];
            $password = $post['password'];
            $chat_id = $post['chat_id'];
        }
        else
        {
            $password = "";
            $chat_id = "";
            $errMsg = ["","",""];
        }
    }
    else
    {
        // ユーザー情報の取得
        $index = $controller->getUserIndex();
        $user_id = $controller->getter_Get('user_id');
        $myPass = $_SESSION['form']['password'];
        echo $myPass;
        echo $user_id;
        if(isset($_POST['return']))
        {
            header('Location: Main.php?user_id='.$user_id);
        }
        // バリデーション
        $post = filter_input_array(INPUT_POST,$_POST);
        // 各送信データの格納
        $password = $post['password'];
        $chat_id = $post['chat_id'];

        // パスワードチェック
        if(mb_strlen($password) < 8)
        {
            $errMsg[0] = "パスワードは8文字以上で入力してください。";
            $_SESSION['delete'] = $post;
        }
        if($errMsg[0] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) 
            {
                $errMsg[0] = "パスワードは半角英数字で入力してください。";
                $_SESSION['delete'] = $post;
            }
        }
        // チャットIDチェック
        if(mb_strlen($chat_id) < 5 || mb_strlen($chat_id) > 10)
        {
            $errMsg[1] = "チャットIDは5文字以上10文字以内で入力してください。";
            $_SESSION['delete'] = $post;
        }
        if($errMsg[1] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $chat_id)) 
            {
                $errMsg[1] = "チャットIDは半角英数字で入力してください。";
                $_SESSION['delete'] = $post;
            }
        }

        $matchFlg = 0;
        if($errMsg[0] === "" && $errMsg[1] === "")
        {
            // パスワードとchatIDが一致するかのチェック
            if($password === $myPass && $user_id === $chat_id)
            {
                $macthFlg = 1;
            }
        }
        if($errMsg[0] === "" && $errMsg[1] === "")
        {
            if($matchFlg)
            {
                $errMsg[2] = "パスワードとチャットIDが一致しません。";
                $_SESSION['delete'] = $post;
            }
        }

        // バリデーション全て通過
        if($errMsg[0] === "" && $errMsg[1] === "" && $errMsg[2] == "")
        {
            if(isset($_POST['go_next']))
            {
                // ユーザー情報を消すフラグを1に
                $_SESSION['delUserFlg'] = 1;
                header('Location: Confirm_delete.php?user_id='.$user_id);
            }
        }
    }
?>

<body>
    <form action = "" method = "POST">
        <div class = "DeleteUser">
            <h1>アカウント削除</h1>
            <div class = "confirmUser">
                <h2>ユーザー確認</h2>
                <?php if($errMsg[2] !== ""):?>
                <p id = "err"><?php echo $errMsg[2]?></p>
                <?php endif;?>
                <p>パスワード</p>
                <?php if($errMsg[0] !== ""):?>
                <p id = "err"><?php echo $errMsg[0]?></p>
                <?php endif;?>
                <input type = "password" placeholder = "Password" value = "" name = "password">
                <p>ユーザーID(チャットID)</p>
                <?php if($errMsg[1] !== ""):?>
                <p id = "err"><?php echo $errMsg[1]?></p>
                <?php endif;?>
                <input type = "text" placeholder = "ChatID" value = "" name = "chat_id">
            </div>
            <div class = "btnArea">
                <input type = "submit" name = "go_next" value = "次へ">
                <input type = "submit" name = "return" value = "戻る">
            </div>
        </div>
    </form>
</body>