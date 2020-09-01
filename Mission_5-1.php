<?php
   $dsn = 'データベース名';
   $user = 'ユーザ名';
   $password = 'パスワード';
   $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
   $sql = "CREATE TABLE IF NOT EXISTS chatroom"
   ." ("
   . "id INT AUTO_INCREMENT PRIMARY KEY,"
   . "name char(32),"
   . "comment TEXT,"
   . "date DATETIME,"
   . "password char(20)"
   .");";
   $stmt = $pdo->query($sql);
   $sql = "SHOW TABLES";
   $result = $pdo -> query($sql);
   foreach ($result as $row){
	  echo $row[0];
	  echo '<br>';
   }
   echo "<hr>";
   if($_POST["add"]) {
              $name = $_POST["name"];
              $str = $_POST["str"];
              $date = new DateTime();
              $date = $date->format('Y-m-d H:i:s');
              $pass1 = $_POST["pass1"];
              $num3 = $_POST["num3"];
              if($num3 != null) {
                 $sql = 'SELECT * FROM chatroom';
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row) {
                    if($pass1 != null && $pass1 == $row['password'] && $num3 == $row['id']) {
                        $sql = 'UPDATE chatroom SET name=:name,comment=:comment,date=:date WHERE id=:id';
	                    $stmt = $pdo->prepare($sql);
	                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	                    $stmt->bindParam(':comment', $str, PDO::PARAM_STR);
	                    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
	                    $stmt->bindParam(':id', $num3, PDO::PARAM_INT);
	                    $stmt->execute();
                    }
                 }
              } else {
                $sql = $pdo -> prepare("INSERT INTO chatroom (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $str, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> bindParam(':password', $pass1, PDO::PARAM_STR);
                $sql -> execute();
              }
   }
   if ($_POST["delete"]) {
                $num1 = $_POST["num1"];
                $pass2 = $_POST["pass2"];
                $sql = 'SELECT * FROM chatroom';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row) {
		           if($pass2 != null && $pass2 == $row['password'] && $num1 == $row['id']){
                     $sql = 'delete from chatroom WHERE id=:id';
	                 $stmt = $pdo->prepare($sql);
	                 $stmt->bindParam(':id', $num1, PDO::PARAM_INT);
	                 $stmt->execute();
		           }
                }
                
   }
   if ($_POST["edit"]) {
                $num2 = $_POST["num2"];
                $pass3 = $_POST["pass3"];
                $sql = 'SELECT * FROM chatroom';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach($results as $row) {
                    if($pass3 != null && $pass3 == $row['password'] && $num2 == $row['id']) {
                        $yourname = $row['name'];
                        $comment = $row['comment'];
                        $pass4 = $row['password'];
                    }
                }
   }
   $sql = 'SELECT * FROM chatroom';
   $stmt = $pdo->query($sql);
   $results = $stmt->fetchAll();
   foreach ($results as $row) {
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';
		echo $row['password'].'<br>';
   echo "<hr>";
   }
?>
<html>
    <head>
        <meta-charset="UTF-8">
        <title>mission_5-01.txt</title>
    </head>
    <body>
        <form action="" method="POST">
            <input type="text" name="name" value="<?php 
                if($yourname != null) {
                    echo $yourname;
                }
              ?>" placeholder="名前">
            <input type="text" name="str" value="<?php
                if($comment != null) {
                    echo $comment;
                }
              ?>" placeholder="コメント">
            <input type="password" name="pass1" value="<?php
               if($pass4 != null) {
                   echo $pass4;
               }
            ?>" placeholder="パスワードを入力">
            <input type="hidden" name="num3" value="<?php
               if($num2 != null) {
                  echo $num2; 
               }
            ?>">
            <input type="submit" name="add" value="投稿">
        </form>
        <form action="" method="POST">
            <input type="number" name="num1" placeholder="投稿番号">
            <input type="password" name="pass2" placeholder="パスワードを入力">
            <input type="submit" name="delete" value="削除">
        </form>
        <form action="" method="POST">
            <input type="number" name="num2" placeholder="投稿番号">
            <input type="password" name="pass3" placeholder="パスワードを入力">
            <input type="submit" name="edit" value="編集">
        </form>
        
    </body>
</html>