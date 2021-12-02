<?php
require_once(ROOT_PATH.'Models/Db.php');
class Users extends Db
{
    // テーブル名
    private $table = "users";
    // コンストラクタ
    public function __construct($db = null)
    {
        parent::__construct($db);
    }
    // ユーザーの情報を全て取得
    public function getIndex():Array
    {
        try {
            $sql = 'SELECT * FROM '.$this->table;
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    // ユーザー情報をIDで取得
    public function getIndexById($user_id = 0)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table.' WHERE chat_id = :user_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->execute();
            $this->db->commit();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    // 登録(SignIn)
    public function registrator($psw,$cid)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'INSERT INTO '.$this->table.' (password, chat_id, role) VALUES (:password, :chat_id, :role)';
            $stmt = $this->db->prepare($sql);
            $params = array(':password' => $psw, ':chat_id' => $cid, ':role' => 0);
            $stmt->execute($params);
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function delete($user_id = 0)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'DELETE FROM '.$this->table.' WHERE chat_id = :user_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->execute();
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    // アカウント編集の際に使用
    public function update($user_id = 0,$password,$chat_id,$imgPath)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'UPDATE '.$this->table.' SET password = :password ,chat_id = :user_id ,image_path = :path WHERE chat_id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id',$user_id);
            $stmt->bindValue(':path',$imgPath);
            $stmt->bindValue(':user_id',$chat_id);
            $stmt->bindValue(':password',$password);
            $stmt->execute();
            $sql = 'UPDATE games SET user_id = :chat_id WHERE user_id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':chat_id',$chat_id);
            $stmt->bindValue(':id',$user_id);
            $stmt->execute();
            $sql = 'UPDATE fav SET user_id = :chat_id WHERE user_id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':chat_id',$chat_id);
            $stmt->bindValue(':id',$user_id);
            $stmt->execute();
            $sql = 'UPDATE browsingstories SET user_id = :chat_id WHERE user_id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':chat_id',$chat_id);
            $stmt->bindValue(':id',$user_id);
            $stmt->execute();

            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
}


?>