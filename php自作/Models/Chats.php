<?php
require_once(ROOT_PATH.'Models/Db.php');
class Chats extends Db
{
    // テーブル名
    private $table = "chats";
    // コンストラクタ
    public function __construct($db = null)
    {
        parent::__construct($db);
    }
    // チャットデータの取得
    public function getData()
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table;
            $stmt = $this->db->prepare($sql);
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
    public function add($user_id,$chat,$opponent)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'INSERT INTO '.$this->table.' (user_id, content,opponent_user_id) VALUES (:user_id, :content,:opponent)';
            $stmt = $this->db->prepare($sql);
            $params = array(':user_id' => $user_id, ':content' => $chat,':opponent' => $opponent);
            $stmt->execute($params);
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function delete($user_id)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'DELETE FROM '.$this->table.' WHERE user_id = :user_id';
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
}