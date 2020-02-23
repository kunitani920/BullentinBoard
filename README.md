# 内定者懇親サイトについて  
内定承諾してから、入社するまでの期間。  
「他の内定者は何人位？年齢は？どんな人？」  
「内定式で会う前に知って欲しい・知っておきたい、話のネタを仕込んでおきたい。」  
そんな願いを叶える、簡易的な懇親サイト。    
https://bullentinboard-tani.herokuapp.com/login.php  
  
## 設計図や、気を付けた点などQiitaに投稿しています  
こちら参照いただけると幸いです。  
[【PHP】就職活動の為の、webアプリ（ポートフォリオ）設計図公開！｜未経験からエンジニアへ](https://qiita.com/tani35web1/items/4bcc36cc2ba96065f788)  
  
## 概要  
### ユーザー種類  
- 管理者  
- メンバー  
### 機能  
- 管理者｜メンバー全員の編集、削除。他の管理者の新規登録、編集、削除  
- メンバー｜自身の登録、編集、削除。他のメンバー 一覧、詳細の閲覧  
### サンプルユーザー（メールアドレス、パスワード）  
- 管理者｜jinji@jinji、word  
- メンバー｜ishida@ishida、ishida  
架空のメールアドレスでメンバー登録も出来ますが、  
こちらのサンプルユーザーにてログインが可能です。  
*IDに関わる部分（メールアドレス、パスワード）は変更しないでください*  
### DB定義  
- jinjies  
```
+------------+--------------+------+-----+-------------------+-----------------------------+  
| Field      | Type         | Null | Key | Default           | Extra                       |  
+------------+--------------+------+-----+-------------------+-----------------------------+  
| id         | int(11)      | NO   | PRI | NULL              | auto_increment              |  
| email      | varchar(100) | NO   |     | NULL              |                             |  
| password   | varchar(255) | NO   |     | NULL              |                             |  
| last_name  | varchar(100) | NO   |     | NULL              |                             |  
| first_name | varchar(100) | NO   |     | NULL              |                             |  
| created    | datetime     | NO   |     | NULL              |                             |  
| modified   | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |  
+------------+--------------+------+-----+-------------------+-----------------------------+  
```  
- memberes
```
+----------+--------------+------+-----+-------------------+-----------------------------+
| Field    | Type         | Null | Key | Default           | Extra                       |
+----------+--------------+------+-----+-------------------+-----------------------------+
| id       | int(11)      | NO   | PRI | NULL              | auto_increment              |
| email    | varchar(100) | NO   |     | NULL              |                             |
| password | varchar(255) | NO   |     | NULL              |                             |
| created  | datetime     | NO   |     | NULL              |                             |
| modified | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+----------+--------------+------+-----+-------------------+-----------------------------+
```
- members_info
```
+----------------+--------------+------+-----+-------------------+-----------------------------+
| Field          | Type         | Null | Key | Default           | Extra                       |
+----------------+--------------+------+-----+-------------------+-----------------------------+
| id             | int(11)      | NO   | PRI | NULL              | auto_increment              |
| member_id      | int(10)      | NO   |     | NULL              |                             |
| last_name      | varchar(100) | NO   |     | NULL              |                             |
| first_name     | varchar(100) | NO   |     | NULL              |                             |
| nick_name      | varchar(100) | NO   |     | NULL              |                             |
| school         | char(10)     | NO   |     | NULL              |                             |
| prefectures_id | int(10)      | NO   |     | NULL              |                             |
| message        | varchar(240) | NO   |     | NULL              |                             |
| icon           | varchar(120) | YES  |     | NULL              |                             |
| modified       | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+----------------+--------------+------+-----+-------------------+-----------------------------+
```
- prefectures
```
+----------+----------+------+-----+---------+----------------+
| Field    | Type     | Null | Key | Default | Extra          |
+----------+----------+------+-----+---------+----------------+
| id       | int(11)  | NO   | PRI | NULL    | auto_increment |
| pre_name | char(10) | NO   |     | NULL    |                |
+----------+----------+------+-----+---------+----------------+
```
- members_interesting
```
+-----------------+-----------+------+-----+-------------------+-----------------------------+
| Field           | Type      | Null | Key | Default           | Extra                       |
+-----------------+-----------+------+-----+-------------------+-----------------------------+
| id              | int(11)   | NO   | PRI | NULL              | auto_increment              |
| member_id       | int(11)   | NO   |     | NULL              |                             |
| interesting1_id | int(11)   | NO   |     | NULL              |                             |
| interesting2_id | int(11)   | NO   |     | NULL              |                             |
| interesting3_id | int(11)   | NO   |     | NULL              |                             |
| modified        | timestamp | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+-----------------+-----------+------+-----+-------------------+-----------------------------+
```
- interesting
```
+-------------+----------+------+-----+---------+----------------+
| Field       | Type     | Null | Key | Default | Extra          |
+-------------+----------+------+-----+---------+----------------+
| id          | int(11)  | NO   | PRI | NULL    | auto_increment |
| intere_name | char(20) | NO   |     | NULL    |                |
+-------------+----------+------+-----+---------+----------------+
```
### 使用言語、フレームワーク  
・PHP 7.3.11  
・HTML/CSS、Bootstrap4  
・MySQL 5.7.26
