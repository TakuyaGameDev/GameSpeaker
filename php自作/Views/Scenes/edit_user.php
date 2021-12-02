<?php include('header.php');?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // 1ユーザーのデータ取得
    $user_info = $controller->getUserIndexById();

    $user_id = $controller->getter_Get("user_id");

    $errMsg = ["","",""];

    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if(!empty($_SESSION['userEdit']))
        {
            $post = $_SESSION['userEdit'];
            $password = $post['password'];
            $chat_id = $post['chat_id'];
        }
        else
        {
            foreach($user_info as $user)
            {
                $password = $user['password'];
                $chat_id = $user['chat_id'];
            }
        }
    }
    else
    {
        if(isset($_POST['returnBtn']))
        {
            unset($_SESSION['userEdit']);
            header('Location: Main.php?user_id='.$user_id);
            exit();
        }
        // データベースに格納されているユーザーデータ
        $userData = $controller->getUserIndex();

        // XSS対策
        $post = filter_input_array(INPUT_POST,$_POST);

        $password = $post['password'];
        $chat_id = $post['chat_id'];
        $imgPath = $_FILES['imgPath']['name'];
            // 入力データが存在するデータかチェック
        foreach($userData as $data)
        {
            if($chat_id == $user_id)
            {
                break;
            }
            if($chat_id === $data['chat_id'])
            {
                $errMsg[2] = "そのchatIDは既に存在します。別のchatIDをご使用下さい";
                break;
            }
        }
        // パスワードチェック
        if(mb_strlen($post['password']) < 8)
        {
            $errMsg[0] = "パスワードは8文字以上で入力してください。";
            // 入力情報の保持
            $_SESSION['userEdit'] = $post;
        }
        if($errMsg[0] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $post['password'])) 
            {
                $errMsg[0] = "パスワードは半角英数字で入力してください。";
                // 入力情報の保持
                $_SESSION['userEdit'] = $post;
            }
        }
        // チャットIDチェック
        if(mb_strlen($post['chat_id']) < 5 || mb_strlen($post['chat_id']) > 10)
        {
            $errMsg[1] = "チャットIDは5文字以上10文字以内で入力してください。";
            // 入力情報の保持
            $_SESSION['userEdit'] = $post;
        }
        if($errMsg[1] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $post['chat_id']))
            {
                $errMsg[1] = "チャットIDは半角英数字で入力してください。";
                // 入力情報の保持
                $_SESSION['userEdit'] = $post;
            }
        }
        if($errMsg[2] !== "")
        {
            $errMsg[0] = "";
            $errMsg[1] = "";
        } 
        if($errMsg[0] === "" && $errMsg[1] === "" && $errMsg[2] === "")
        {
            $_SESSION['userEdit'] = $post;
            $_SESSION['userEdit']['imgPath'] = $imgPath;
            header('Location: Confirm_edit_user.php?user_id='.$user_id);
        }
    }
?>

<body>
    <form id = "submit" action = "" method = "POST" enctype="multipart/form-data">
        <div class = "edit_user">
            <h1>アカウント編集</h1>
            <?php if($errMsg[2] != ""):?>
                <p id = "err"><?php echo $errMsg[2];?></p>
            <?php endif;?>
            <div class = "input">
                <?php if($errMsg[0] != ""):?>
                    <p id = "err"><?php echo $errMsg[0];?></p>
                <?php endif;?>
                <p>新パスワード : <input type = "password" name = "password" placeholder="パスワード" value = <?php echo $password;?>></p>
            </div>
            <div class = "input">
                <?php if($errMsg[1] != ""):?>
                    <p id = "err"><?php echo $errMsg[1];?></p>
                <?php endif;?>
                <p>新チャットID : <input type = "text" name = "chat_id" placeholder="チャットID" value = <?php echo $chat_id;?>></p>
            </div>
            <div class = "imgPathInput">
                <p>プロフィール画像 : <input id = "fileInput" type = "file" name = "imgPath" accept="image/jpeg,image/png"></p>
                <canvas id="canvas" width="640" height="480"></canvas>
            </div>
            <input id = "exeBtn" type = "submit" name = "exeBtn" value = "次へ">
            <input id = "return" type = "submit" name = "returnBtn" value = "戻る">
        </div>
        
    </form>
</body>