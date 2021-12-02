<?php
require_once(ROOT_PATH.'Models/Db.php');
class BrowsingHis extends Db
{
    // テーブル名
    private $table = "browsingstories";
    // コンストラクタ
    public function __construct($db = null)
    {
        parent::__construct($db);
    }

    // 閲覧履歴に登録(自分がどのジャンルを見たかのカウントアップ)
    function register($user_id,$junre)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table.' WHERE user_id = :user_id AND junre = :junre';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->bindValue(':junre',$junre);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->db->commit();

            $this->db->beginTransaction();
            // ある場合
            if(!$result)
            {
                $sql = 'INSERT INTO '.$this->table.' (user_id, junre, count) VALUES (:user_id, :junre, count+1)';
                $stmt = $this->db->prepare($sql);
            }
            // ない場合
            else
            {
                $sql = 'UPDATE '.$this->table.' SET count=count+1 WHERE user_id = :user_id AND junre = :junre';
                $stmt = $this->db->prepare($sql);
            }
            $stmt->bindValue(':user_id',$user_id);
            $stmt->bindValue(':junre',$junre);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function getById($user_id = 0)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function deleteByUserId($user_id)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'DELETE FROM '.$this->table." WHERE user_id = :user_id";
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
?>