<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();

    $content = "";

    $myId = $controller->getter_Get("user_id");
    $opponentId = $controller->getter_Get("postUser_id");

    // 送信ボタンを押していない場合
    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $content = "";
        $chatArray = $controller->getChatData();
    }
    else
    {
        if(isset($_POST['return_Btn']))
        {
            $name = $controller->getter_Get("name");
            $junre = $controller->getter_Get("junre");
            header('Location: detail.php?name='.$name.'&user_id='.$opponentId.'&junre='.$junre);
        }

        $post = filter_input_array(INPUT_POST,$_POST);
        $content = $post['chat'];

        if(mb_strlen($content) <= 0)
        {

        }
        else
        {
            // チャットデータの追加
            $controller->addChatData();
        }
        $chatArray = $controller->getChatData();
    }

?>

<script>

</script>

<head>
<link rel="stylesheet" type="text/css" href="/css/chat.css">
</head>
<body>
<h1 align="center" style="margin-top:80px;">チャット画面</h1>
<p align="center" style="font-size:24px;"><?php echo $opponentId?>さんとのチャット</p>
    <div id = "chat">
        <div id = "chatArea">
            <?php foreach($chatArray as $chat):?>
                    <?php if($chat['user_id'] == $myId && $chat['opponent_user_id'] == $opponentId): ?>
                        <div class="balloon-left">
                            <p><?php echo nl2br($chat['content']);?></p>
                        </div>
                    <?php endif;?>
                    <?php if($chat['user_id'] == $opponentId && $chat['opponent_user_id'] == $myId): ?>
                        <div class="balloon-right">
                            <p><?php echo nl2br($chat['content']);?></p>
                        </div>
                    <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
    
    <form id = "chatForm" action = "" method = "POST">
        <div class = "inputTextArea">
            <textarea name = "chat" placeholder="ここにチャット内容を入力してください"></textarea>
            <div class = "btn">
                <input type = "submit" name = "submit_chat" value = "送信" id = "chatSubBtn">
            </div>
        </div>
        <input id = "chatReturn" type = "submit" name = "return_Btn" value = "戻る">
    </form>
    
</body>