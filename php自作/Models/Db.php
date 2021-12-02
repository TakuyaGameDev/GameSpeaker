<?php

require_once(ROOT_PATH.'/Database.php');

class Db
{
    protected $db;

    public function __construct($db = null)
    {
        // 接続状態が存在しない場合
        if(!$db)
        {
            try
            {
                $this->db = new PDO('mysql:dbname='.DB_NAME.
                ';host='.DB_HOST,DB_USER,DB_PASSWD);
            }
            catch(PDOException $e)
            {
                // 接続成功
                echo "接続失敗:".$e->getMessage()."<br>";
                exit();
            }
        }
        else
        {
            // 接続状態が存在する場合
            $this->db = $db;
        }
    }

    public function get_db_handler()
    {
        return $this->db;
    }
}
?>