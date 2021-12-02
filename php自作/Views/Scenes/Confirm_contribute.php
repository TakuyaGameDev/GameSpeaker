<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    $post = $_SESSION['contribute'];
    $name = $post['name'];
    $junre = $post['junre'];
    $value = $post['value'];
    $intro = $post['intro'];
    $intro2 = preg_replace("/\r\n|\n|\r/","\n",$intro);
    $id = $controller->getter_Get("user_id");
    if(isset($_POST['contribute']))
    {
        $controller->registrateGameInfo();
        unset($_SESSION['contribute']);
        header('Location: Main.php?user_id='.$id);
    }
    if(isset($_POST['returnBtn']))
    {
        $post = filter_input_array(INPUT_POST,$_POST);
        $_SESSION['confirm'] = $post;
        
        header('Location: Contribute.php?user_id='.$id);
    }
?>

<body>
    <div class = "Contribute">
        <h1 align="center">確認</h1>
        <form action="" method="POST">
            <div class = "inputArea">
                <div class = "name_junre" align="center">
                    <p>ジャンル</p>
                    <input type = "text" name = "junre" value = "<?php echo $junre?>" readonly>
                </div>
                <div class = "name_game" align="center">
                    <p>ゲーム名</p>
                    <input type = "text" name = "name" value = "<?php echo $name?>" readonly>
                </div>
                <div class = "value" align="center">
                    <p>評価値</p>
                    <input type = "text" name = "value" value = <?php echo $value?> readonly>
                </div>
                <div class = "comment" align="center">
                    <p>コメント</p>
                    <textarea name = "intro" readonly  cols="50" rows="10" wrap="hard"><?php echo $intro?></textarea>
                </div>
            </div>
            <div class = "btnArea" align="center">
                <div class = "exeBtn">
                    <input type = "submit" name = "contribute" value = "投稿" style="font-size:24px;">
                </div>
                <div class = "rtnBtn">
                    <input class ="rtnBtn" type = "submit" name = "returnBtn" value = "戻る" style="font-size:24px;">
                </div>
            </div>
        </form>
    </div>
</body>