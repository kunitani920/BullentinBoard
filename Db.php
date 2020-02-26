<?php

class Db
{
    public function dbconnect() {
        try {            
            $config = include(__DIR__ . './config/config.php');
            
            $dbh = new PDO($config['dsn'],$config['user'],$config['password'],$config['options']);
            // $dbh = new PDO($dsn,$user,$password,$options);
        } catch(PDOException $e) {
            echo 'DB接続エラー：' . $e->getMessage();
        }
        return $dbh;
    }
}

//     // トランザクション開始
//     $dbh->beginTransaction();
// 	// UPDATE
// 	$sql = "UPDATE user_list SET age = 24 WHERE id = 4";

// 	// クエリ実行
// 	$res = $dbh->query($sql);

// 	// コミット
// 	$dbh->commit();

// } catch(PDOException $e) {
	
// 	// ロールバック
// 	$dbh->rollBack();

// 	// エラーメッセージ出力
// 	echo $e->getMessage();
// 	die();
// }

// // 接続を閉じる
// $dbh = null;


    // private $dsn = 'mysql:dbname=naiteisya;host=127.0.0.1;charset=utf8';
    // private $dbuser = ''; localで実験する時用
    // private $dbpassword = '';    localで実験する時用

    // public function dbconnect() {
    //     try {
    //         $pdo = new PDO($this->dsn, $this->dbuser, $this->dbpassword);


?>