<?php include('header.php')?>
<?php
    require_once(ROOT_PATH."Controllers/Controller.php");
    // コントローラーのインスタンス
    $controller = new Controller();
    // 編集データ
    $editData = $_SESSION['userEdit'];

    if(isset($_POST['return']))
    {
        header('Location: edit_user.php?user_id='.$user_id);
    }

    if(isset($_POST['exe']))
    {
        if($editData['imgPath'] == "")
        {
            $editData['imgPath'] = NULL;
        }
        $controller->updateUser($editData['imgPath']);
        header('Location: Login.php');
    }
?>

<body>
    <form action = "" method = "POST">
        <div class = "confirm_editUser">
            <h1>編集内容確認</h1>
            <div class = "views">
                <p>&emsp;変更後のパスワード : <input type = "text" name = "password" value = <?php echo $editData['password'];?> readonly></p>
                <p>&emsp;変更後のチャットID : <input type = "text" name = "chat_id" value = <?php echo $editData['chat_id'];?> readonly></p>
                <p>設定プロフィール画像 : <input id = "fileInput" type = "text" name = "imgPath" accept="image/jpeg,image/png" value = <?php if($editData['imgPath'] != ""){ echo $editData['imgPath'];}else{echo "指定なし";}?> readonly></p>
                <p id = "sample"></p>
            </div>
            <input type = "submit" name = "exe" value = "実行">
            <input type = "submit" name = "return" value = "戻る">
        </div>
    </form>
</body>