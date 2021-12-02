
<?php

require_once(ROOT_PATH."/Models/Users.php");
require_once(ROOT_PATH."/Models/Games.php");
require_once(ROOT_PATH."/Models/BrowsingHis.php");
require_once(ROOT_PATH."/Models/Favs.php");
require_once(ROOT_PATH."/Models/Chats.php");
class Controller 
{
    // ユーザーモデル
    private $users;
    // ゲームモデル
    private $games;
    // 閲覧履歴モデル
    private $browsingStories;
    // 「いいね！」モデル
    private $favs;
    // チャットモデル
    private $chats;
    public function __construct() {
        $this->request["get"] = $_GET;
        $this->request["post"] = $_POST;
        filter_input_array(INPUT_POST,$_POST);
        $this->users = new Users();
        // データベースの取得
        $db = $this->users->get_db_handler();
        // ゲームモデルのインスタンス
        $this->games = new Games($db);
        // 閲覧履歴モデルのインスタンス
        $this->browsingStories = new BrowsingHis($db);
        // 「いいね！」モデルのインスタンス
        $this->favs = new Favs($db);
        // チャットモデルのインスタンス
        $this->chats = new Chats($db);
    }
    // データーベース取得
    public function getDb()
    {
        return $this->users->get_db_handler();
    }
    // ユーザーの更新
    public function updateUser($imgPath)
    {
        $this->users->update($this->request['get']['user_id'],
                             $this->request['post']['password'],
                            $this->request['post']['chat_id'],$imgPath);
    }
    // ユーザーの情報の取得
    public function getUserIndex():Array
    {
        return $this->users->getIndex();
    }
    // ユーザー情報をIDで取得
    public function getUserIndexById():Array
    {
        return $this->users->getIndexById($this->request['get']['user_id']);
    }
    // ユーザー情報登録
    public function registrateUserInfo()
    {
        $this->users->registrator($this->request["post"]["password"],$this->request["post"]["chat_id"]);
    }
    // 特定のユーザーの消去(user_idで決定)
    public function deleteUserById()
    {
        $this->users->delete($this->request['get']['user_id']);
    }
    // ゲームのコメント等の情報登録
    public function registrateGameInfo()
    {
        if(empty($this->request["get"]["user_id"]))
        {
            echo "ユーザーIDが未設定です";
        }
        $this->games->registrator($this->request["post"]["name"],
                                  $this->request["post"]["junre"],
                                  $this->request["post"]["value"],
                                  $this->request["get"]["user_id"],
                                  $this->request["post"]["intro"]);
    }
    // 閲覧履歴の登録
    public function registrateBrowsingHis($user_id)
    {
        $this->browsingStories->register($user_id,$this->request["get"]["junre"]);
    }
    // 閲覧履歴の取得
    public function getHistoryById($user_id = 0)
    {
        return $this->browsingStories->getById($user_id);
    }
    // 特定のユーザーの閲覧履歴の削除
    public function deleteBrowsingHisByUserId()
    {
        $this->browsingStories->deleteByUserId($this->request['get']["user_id"]);
    }
    
    public function updateGameInfo()
    {
        $this->games->update($this->request["get"]["id"],
                             $this->request["get"]["user_id"],
                             $this->request["post"]["value"],
                             $this->request["post"]["intro"]);
    }
    public function deleteGameInfoById()
    {
        $this->games->deleteById($this->request["get"]["id"],$this->request["get"]["user_id"]);
    }
    // ゲーム情報の消去(user_idが一致するデータ全ての消去)
    public function deleteGameInfoByUserId()
    {
        $this->games->deleteByUserId($this->request['get']['user_id']);
    }
    public function getGameIndexById($method = "")
    {
        if($method === "POST")
        {
            if(!isset($this->request['post']["user_id"]) || !isset($this->request['post']["id"]))
            {
                return 0;
            }
            return $this->games->getIndexById($this->request["post"]["user_id"],$this->request["post"]["id"]);
        }
        else if($method === "GET")
        {
            if(!isset($this->request['get']["user_id"]) || !isset($this->request['get']["id"]))
            {
                return 0;
            }
            return $this->games->getIndexById($this->request["get"]["user_id"],$this->request["get"]["id"]);
        }
    }
    // 名前のみでゲームの投稿データを取ってくる
    public function getGameIndexByNameOnly()
    {
        return $this->games->getIndexByNameOnly($this->request["get"]["name"]);
    }
    // Page単位で一覧取得
    public function getGameIndexByNameOnlyPerPage()
    {
        $page = 0;
        if(isset($this->request['get']['page']))
        {
            $page = $this->request['get']['page'];
        }
        return $this->games->getIndexByNameOnlyPerPage($this->request['get']['name'],$page);
    }
    // 名前とジャンルで投稿データの取得
    public function getGameIndexByNameAndJunre()
    {
        return $this->games->getIndexByNameAndJunre($this->request["get"]["name"],$this->request["get"]["junre"]);
    }
    // ゲーム情報をジャンル名で取得する(これはGETしてきたものでないもので取得)
    public function getGameIndexByJunre($junre)
    {
        return $this->games->getIndexByJunre($junre);
    }
    public function getGameIndexPageByJunre($junre)
    {
        $page = 0;
        if(isset($this->request['get']['page']))
        {
            $page = $this->request['get']['page'];
        }
        return $this->games->getIndexPageByJunre($junre,$page);
    }
    // 名前とジャンルで取り出す(Page単位で)
    public function getGameIndexNameAndJunrePerPage()
    {
        $page = 0;
        if(isset($this->request['get']['page']))
        {
            $page = $this->request['get']['page'];
        }
        return $this->games->getIndexByNameAndJunrePerPage($this->request['get']['name'],$this->request['get']['junre'],$page);
    }
    // user_idで投稿一覧取得
    public function getGameIndexByUserId($method = "")
    {
        if($method === "POST")
        {
            return $this->games->getIndexByUserId($this->request["post"]["user_id"]);
        }
        else if($method === "GET")
        {
            return $this->games->getIndexByUserId($this->request["get"]["user_id"]);
        }
    }
    // ゲーム名で一覧の取得
    public function getGameIndexByName($method = "")
    {
        if($method === "POST")
        {
            return $this->games->getIndexByName($this->request["post"]["name"],$this->request["get"]["user_id"]);
        }
        else if($method === "GET")
        {
            return $this->games->getIndexByName($this->request["get"]["name"],$this->request["get"]["user_id"]);
        }
    }
    public function getRecentlyGamePageIndex()
    {
        $page = 0;
        if(isset($this->request['get']['page']))
        {
            $page = $this->request['get']['page'];
        }
        return $this->games->getRecentlyPage($page);
    }
    // 最近の投稿のゲームを取得
    public function getRecentlyGamesInfo()
    {
        return $this->games->getRecently();
    }
    public function updateFav($user_id,$post_id)
    {
        $this->favs->update($user_id,$post_id);
    }
    public function deleteFavByUserId()
    {
        $this->favs->deleteByUserId($this->request['get']['user_id']);
    }
    public function isExistUserFromFav($post_id = 0)
    {
        if(!empty($this->favs->get($this->request['get']['user_id'],$post_id)))
        {
            return true;
        }
        return false;
    }
    //「いいね！」のデータ一覧取得
    public function getFavIndex($post_id)
    {
        return $this->favs->getIndex($post_id);
    }

    // データベースへのチャットデータの追加
    public function addChatData()
    {
        $this->chats->add($this->request['get']['user_id'],$this->request['post']['chat'],$this->request['get']['postUser_id']);
    }

    // チャットデータのIDでの取得(自分のチャットデータ)
    public function getChatData()
    {
        return $this->chats->getData();
    }
    // チャットデータの削除(ユーザー指定)
    public function deleteChatData()
    {
        $this->chats->delete($this->request['get']['user_id']);
    }

    // $_GETのゲット関数
    public function getter_Get($getStr)
    {
        if(!isset($this->request['get']["$getStr"]))
        {
            return 0;
        }
        return $this->request['get']["$getStr"];
    }
    // $_POSTのゲット関数
    public function getter_Post($postStr)
    {
        if(!isset($this->request['post']["$postStr"]))
        {
            return 0;
        }
        return $this->request['post']["$postStr"];
    }
}

?>