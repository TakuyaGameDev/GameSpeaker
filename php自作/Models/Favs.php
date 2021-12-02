<?php
require_once(ROOT_PATH.'Models/Db.php');
class Favs extends Db
{
    // テーブル名
    private $table = "fav";
    // コンストラクタ
    public function __construct($db = null)
    {
        parent::__construct($db);
    }
    public function findById($user_id,$post_id)
    {
        try {
            $sql = 'SELECT * FROM '.$this->table.' WHERE user_id = :user_id AND post_id = :post_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->bindValue(':post_id',$post_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    // データベース内の特定のいいねのdel_flgの取得関数
    public function del_flg($user_id,$post_id)
    {
        $sql = 'SELECT * FROM '.$this->table.' WHERE user_id = :user_id AND post_id = :post_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id',$user_id);
        $stmt->bindValue(':post_id',$post_id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['del_flg'];
    }

    public function update($user_id,$post_id)
    {
        try {
            $this->db->beginTransaction();
            // del_flgが0のやつを取得
            $result = $this->findById($user_id,$post_id);
            // ユーザーIDで見つからなかったら「いいね」していない事になるのでユーザー情報で「いいね」情報を登録
            if(!$result)
            {
                $sql = 'INSERT INTO '.$this->table.' (user_id, post_id) VALUES (:user_id, :post_id)';
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':user_id',$user_id);
                $stmt->bindValue(':post_id',$post_id);
                $stmt->execute();
                $this->db->commit();
            }
            else
            {
                $del_flg = 0;
                if($this->del_flg($user_id,$post_id) == 1)
                {
                    $del_flg = 0;
                }
                else
                {
                    $del_flg = 1;
                }
                $sql = 'UPDATE '.$this->table.' SET del_flg = :del_flg WHERE user_id = :user_id AND post_id = :post_id';
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':del_flg',$del_flg);
                $stmt->bindValue(':user_id',$user_id);
                $stmt->bindValue(':post_id',$post_id);
                $stmt->execute();
                $this->db->commit();
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    // データ取得
    public function getIndex($post_id)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table.' WHERE post_id = :post_id AND del_Flg = :del_flg';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':post_id',$post_id);
            $stmt->bindValue(':del_flg',0);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->db->commit();
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    // データ削除(user_idを元に)
    public function deleteByUserId($user_id)
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
    // その投稿にそのユーザーが既に「いいね！」しているかの取得
    public function get($user_id,$post_id)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table.' WHERE user_id = :user_id AND post_id = :post_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->bindValue(':post_id',$post_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->db->commit();
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
}
?>