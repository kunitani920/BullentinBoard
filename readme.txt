●不正アクセス防止
下記のページでID確認を行う。ID確認が出来ないと、ログインページへ戻す。
・list,detail,new_registration_db　他（コマンドで探す！）
editページは、edit_idがなければDBアクセスされず、listページに入って弾かれるので問題なし。

●パスワード
password_hashを採用
https://www.php.net/manual/ja/function.password-hash.php