<?php
session_start();
unset($_SESSION['form']);
require_once(ROOT_PATH."Controllers/Controller.php");
$controller = new Controller();

// エラーメッセージ格納用変数
$errMsg = ["","",""];
// 送信ボタンを押していない場合
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    // 入力情報があれば
    if(!empty($_SESSION['form']))
    {
        $post = $_SESSION['form'];
        $password = $post['password'];
        $chat_id = $post['chat_id'];
    }
    // 無ければ
    else
    {
        $password = "";
        $chat_id = "";
    }
}
// 押している場合
else
{
    if(isset($_POST['return']))
    {
        header('Location: LogIn.php');
    }
    // XSS対策
    $post = filter_input_array(INPUT_POST,$_POST);
    // パスワードとチャットIDの格納
    $password = $post['password'];
    $chat_id = $post['chat_id'];

    // ユーザーの全データの取得
    $userData = $controller->getUserIndex();
    // 入力データが存在するデータかチェック
    foreach($userData as $data)
    {
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
        $_SESSION['form'] = $post;
    }
    if($errMsg[0] === "")
    {
        if (!preg_match("/^[a-zA-Z0-9]+$/", $post['password'])) 
        {
            $errMsg[0] = "パスワードは半角英数字で入力してください。";
            // 入力情報の保持
            $_SESSION['form'] = $post;
        }
    }
    // チャットIDチェック
    if(mb_strlen($post['chat_id']) < 5 || mb_strlen($post['chat_id']) > 10)
    {
        $errMsg[1] = "チャットIDは5文字以上10文字以内で入力してください。";
        // 入力情報の保持
        $_SESSION['form'] = $post;
    }
    if($errMsg[1] === "")
    {
        if (!preg_match("/^[a-zA-Z0-9]+$/", $post['chat_id'])) 
        {
            $errMsg[1] = "チャットIDは半角英数字で入力してください。";
            // 入力情報の保持
            $_SESSION['form'] = $post;
        }
    }

    if($errMsg[2] !== "")
    {
        $errMsg[0] = "";
        $errMsg[1] = "";
    }
    if($errMsg[0] === "" && $errMsg[1] === "" && $errMsg[2] === "")
    {
        $controller->registrateUserInfo();
        header('Location: LogIn.php');
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
        <form action="" method="POST">
        <div class = "Signin_screen">
        <div class = "blank"></div>
        <div class = "titleImg"></div>
            <div class = "SignIn">
                <h1>SIGNIN</h1>
                <?php if($errMsg[2] !== ""):?>
                <p id = "err"><?php echo $errMsg[2]?></p>
                <?php endif;?>
                <div class = "inputArea" align="center">
                    <div class = "passInput">
                        <p>パスワードを入力してください</p>
                        <?php if($errMsg[0] !== ""):?>
                        <p id = "err"><?php echo $errMsg[0]?></p>
                        <?php endif;?>
                        <input type = "password" placeholder="password" name = "password" value = <?php echo $password;?>>
                    </div>
                    <div class = "chat_idInput">
                        <p>チャットIDを入力してください</p>
                        <?php if($errMsg[1] !== ""):?>
                        <p id = "err"><?php echo $errMsg[1]?></p>
                        <?php endif;?>
                        <input type = "text" placeholder="chat_id" name = "chat_id" value = <?php echo $chat_id;?>>
                    </div>
                </div>
                <div class = "enterBtn" align="center">
                    <input type = "submit" value = "サインイン" style="font-size:24px; font-weight:bold;" name = "signin">
                </div>
                <div class = "returnBtn" align="center">
                    <input type = "submit" value = "戻る" style="font-size:24px; font-weight:bold;" name = "return">
                </div>
            </div>
        </form>
    </body>
</html>