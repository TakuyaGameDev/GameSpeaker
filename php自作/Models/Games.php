<?php
require_once(ROOT_PATH.'Models/Db.php');
class Games extends Db
{
    // テーブル名
    private $table = "games";
    // コンストラクタ
    public function __construct($db = null)
    {
        parent::__construct($db);
    }
    // user_idとidで情報取得
    public function getIndexById($user_id,$id):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE user_id = :user_id AND id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
            $stmt->bindValue(':id',$id);
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
    // user_idで情報取得
    public function getIndexByUserId($user_id):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':user_id',$user_id);
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
    // 名前のみで取ってくる
    public function getIndexByNameOnly($name):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE name = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name',$name);
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
    // 名前のみで取ってくる(Page単位)
    public function getIndexByNameOnlyPerPage($name,$page):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE name = :name";
            $sql .= ' LIMIT 2 OFFSET '.(2 * $page);
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name',$name);
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
    // 名前とジャンルで取ってくる
    public function getIndexByNameAndJunre($name,$junre):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE name = :name AND junre = :junre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':junre',$junre);
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
    // 名前とジャンルで取ってくる
    public function getIndexByNameAndJunrePerPage($name,$junre,$page):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE name = :name AND junre = :junre";
            $sql .= ' LIMIT 2 OFFSET '.(2 * $page);
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':junre',$junre);
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
    // 名前で一覧取得
    public function getIndexByName($name,$user_id):Array
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table." WHERE name = :name AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':user_id',$user_id);
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
    // ジャンル名でゲーム情報の取得
    public function getIndexByJunre($junre)
    {
        try {
            $sql = 'SELECT * FROM '.$this->table.' WHERE junre = :junre';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':junre',$junre);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    public function getIndexPageByJunre($junre,$page)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'SELECT * FROM '.$this->table.' WHERE junre = :junre';
            $sql .= ' LIMIT 2 OFFSET '.(2 * $page);
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':junre',$junre);
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
    public function registrator($name,$junre,$value,$user_id,$intro)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'INSERT INTO '.$this->table.' (name, junre, value,user_id,intro) VALUES (:name, :junre, :value, :user_id, :intro)';
            $stmt = $this->db->prepare($sql);
            $params = array(':name' => $name, ':junre' => $junre, ':value' => $value, ':user_id' => $user_id, ':intro' => $intro);
            $stmt->execute($params);
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function update($id,$user_id,$value,$intro)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'UPDATE '.$this->table.' SET value = :value, intro = :intro WHERE user_id = :user_id AND id = :id';
            $stmt = $this->db->prepare($sql);
            $params = array(':value' => $value, ':user_id' => $user_id, ':intro' => $intro,':id' => $id);
            $stmt->execute($params);
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
            $this->db->rollBack();
        }
    }
    public function deleteById($id = 0,$user_id)
    {
        try {
            $this->db->beginTransaction();
            $sql = 'DELETE FROM '.$this->table.' WHERE id = :id AND user_id = :user_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id',$id);
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
    public function deleteByUserId($user_id = 0)
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
    // 最近の投稿(投稿時から1日経過していないもの)を抽出
    public function getRecently()
    {
        try {
            $sql = 'SELECT * FROM '.$this->table.' WHERE (TIMESTAMPDIFF(day,time,CURRENT_DATE)) <= 1 ORDER BY time DESC';
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            $this->db->commit();
        } 
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
        // 最近の投稿(投稿時から1日経過していないもの)を抽出
        public function getRecentlyPage($page)
        {
            try {
                $this->db->beginTransaction();
                $sql = 'SELECT * FROM '.$this->table.' WHERE (TIMESTAMPDIFF(day,time,CURRENT_DATE)) <= 1';
                $sql .= ' LIMIT 2 OFFSET '.(2 * $page);
                $stmt = $this->db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
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