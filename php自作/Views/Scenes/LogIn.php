
<?php
session_start();
    // 各入力情報のリセット-----------------
    unset($_SESSION['form']);
    unset($_SESSION['contribute']);
    // -------------------------------------
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // エラーメッセージ格納用変数
    $errMsg = ["","",""];
    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if(!empty($_SESSION['form']))
        {
            $post = $_SESSION['form'];
            $password = $post['password'];
            $chat_id = $post['chat_id'];
        }
        else
        {
            $password = "";
            $chat_id = "";
        }
        // エラーメッセージ格納用変数
        $errMsg = ["","",""];
    }
    // 押している場合
    else
    {
        if(isset($_POST['signin']))
        {
            header('Location: SignIn.php');
            exit();
        }
        // データベースから全データを取得する
        $index = $controller->getUserIndex();
        // XSS対策
        $post = filter_input_array(INPUT_POST,$_POST);
        $password = $post['password'];
        $chat_id = $post['chat_id'];

        // パスワードチェック
        if(mb_strlen($password) < 8)
        {
            $errMsg[0] = "パスワードは8文字以上で入力してください。";
            $_SESSION['form'] = $post;
        }
        if($errMsg[0] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) 
            {
                $errMsg[0] = "パスワードは半角英数字で入力してください。";
                $_SESSION['form'] = $post;
            }
        }
        // チャットIDチェック
        if(mb_strlen($chat_id) < 5 || mb_strlen($chat_id) > 10)
        {
            $errMsg[1] = "チャットIDは5文字以上10文字以内で入力してください。";
            $_SESSION['form'] = $post;
        }
        if($errMsg[1] === "")
        {
            if (!preg_match("/^[a-zA-Z0-9]+$/", $chat_id)) 
            {
                $errMsg[1] = "チャットIDは半角英数字で入力してください。";
                $_SESSION['form'] = $post;
            }
        }

        $matchFlg = 0;
        if($errMsg[0] === "" && $errMsg[1] === "")
        {
            foreach($index as $idx)
            {
                // パスワードとチャットIDの認証
                if(($idx['password'] === $password) &&
                ($idx['chat_id'] === $chat_id))
                {
                    // 一致したらflgをtrueにしてforeachから抜ける
                    $matchFlg = 1;
                    break;
                }
                else
                {
                    // 一致しない
                    $matchFlg = 0;
                    $_SESSION['form'] = $post;
                }
            }
        }
        if($errMsg[0] === "" && $errMsg[1] === "")
        {
            if(!$matchFlg)
            {
                $errMsg[2] = "パスワードとチャットIDが一致しません。";
                $_SESSION['form'] = $post;
            }
        }
        if(isset($_POST['member']))
        {
            // 何もエラーがないとMainに遷移
            if($errMsg[0] === "" && $errMsg[1] === "" && $errMsg[2] === "")
            {
                $_SESSION['form'] = $post;
                header('Location: Main.php?user_id='.$chat_id);
                exit();
            }
        }

        if(isset($_POST['nonMember']))
        {
            $_SESSION['form'] = array('chat_id' => "00000000");
            header('Location: Main.php?user_id='."00000000");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Game Speaker</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/process.js"></script>
<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
    <body>
    <div class = "Login_screen">
    <form action="" method="POST">
            <div class = "signinBtn" align="right">
                <input type="submit" value="SignIn" style="font-size:28px;" name="signin">
            </div>
        <div class = "titleImg"></div>
            <div class = "LogIn">
                <h1>LOGIN</h1>
                <?php if($errMsg[2] !== ""):?>
                <p id = "err"><?php echo $errMsg[2]?></p>
                <?php endif;?>
                <div class = "inputArea" align="center">
                    <div class = "passInput">
                        <p>パスワードを入力してください</p>
                        <?php if($errMsg[2] === "" && $errMsg[0] !== ""):?>
                        <p id = "err"><?php echo $errMsg[0]?></p>
                        <?php endif;?>
                        <input type = "password" placeholder="password" name = "password" value=<?php echo $password;?>>
                    </div>
                    <div class = "chat_idInput">
                        <p>チャットIDを入力してください</p>
                        <?php if($errMsg[2] === "" && $errMsg[1] !== ""):?>
                        <p id = "err"><?php echo $errMsg[1]?></p>
                        <?php endif;?>
                        <input type = "text" placeholder="chat_id" name = "chat_id" value=<?php echo $chat_id;?>>
                    </div>
                </div>
                <div class = "enterBtn" align="center">
                    <div class = "member">
                        <input type = "submit" value = "ログイン" style="font-size:24px; font-weight:bold;" name = "member">
                    </div>
                    <div class = "nonMember">
                        <input type = "submit" value = "非会員でログイン" style="font-size:24px; font-weight:bold;" name = "nonMember">
                    </div>
                </div>
            </div>
        </form>
        </div>
    </body>
</html>