<html>
    <head>
      <meta name='viewport' content='width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes'>
      <title>5-04</title>
    </head>
    <body>
        
    <?php
    $dsn = 'mysql:dbname=tb270560db;host=localhost';
    $user = 'tb-270560';
    $password = 'u7bf9T85g8';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $edit_name = "";
    $edit_comment = "";
    $edit_id = "";

    
    if(isset($_POST["post_comment"]) && !empty($_POST["name"]) && !empty($_POST["comment"])){
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $date = date("Y-m-d H:i:s");
        $passward = $_POST["passward"];
        
        $sql = "INSERT INTO tb5_4 (name, comment, date, passward) VALUES (:name, :comment, :date, :passward)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":passward", $passward, PDO::PARAM_STR);
        $stmt->execute();
    };
    
    if(isset($_POST["post_delete"]) && !empty($_POST["delete"]) && !empty($_POST["passward_delete"])){
        $id = $_POST["delete"];
        $check_sql = 'SELECT passward FROM tb5_4 WHERE id = :id';
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $check_stmt->execute();
        $result = $check_stmt->fetch();
        
        if($_POST["passward_delete"] == $result["passward"]){
            $sql = 'delete from tb5_4 where id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        };
    };
    
    if(isset($_POST["post_edit"]) && !empty($_POST["edit"]) && !empty($_POST["passward_edit"])){
        $id = $_POST["edit"];
        $check_sql = 'SELECT passward FROM tb5_4 WHERE id = :id';
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $check_stmt->execute();
        $result = $check_stmt->fetch();
        
        if($_POST["passward_edit"] == $result["passward"])
        $sql = 'SELECT * FROM tb5_4 WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        if(count($results) > 0){
            $edit_name = $results[0]['name'];
            $edit_comment = $results[0]['comment'];
            $edit_id = $results[0]['id'];
        }
    };
    
    if(isset($_POST["post_update"]) && !empty($_POST["edit_id"]) && !empty($_POST["name"]) && !empty($_POST["comment"])){
    $id = $_POST["edit_id"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    
    $sql = "UPDATE tb5_4 SET name = :name, comment = :comment WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    };
    
    
    echo '<table border="1">
        <tr>
        <th>投稿番号</th>
        <th>Name</th>
        <th>Comment</th>
        <th>Date</th>
        </tr>';
        
    $sql = 'SELECT * FROM tb5_4';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
        
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['comment']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "</tr>";
    };
    echo "</table>";
    ?>
    
    <form method='POST' action=''>
        <?php if($edit_id != ""): ?>
        <input type='hidden' name='edit_id' value='<?php echo $edit_id; ?>'>
        <?php endif; ?>
        
         お名前：<input type='text' name='name' value='<?php echo $edit_name; ?>'><br />
         コメント：<input type='text' name='comment' value='<?php echo $edit_comment; ?>'><br />
         パスワード：<input type='text' name='passward'><br />
        
        <?php if($edit_id != ""): ?>
        <input type='submit' name='post_update' value='更新'>
        <?php else: ?>
        <input type='submit' name='post_comment' value='送信'>
        <?php endif; ?>
        
        </form>
        </div>
        
        <form method='POST' action=''>
         削除対象番号：<input type='text' name='delete'><br />
         パスワード：<input type='text' name='passward_delete'><br />
        <input type='submit' name='post_delete' value='削除'>
        </form>
        </div>
        
        <form method='POST' action=''>
         編集対象番号：<input type='text' name='edit'><br />
         パスワード：<input type='text' name='passward_edit'><br />
        <input type='submit' name='post_edit' value='編集'>
        </form>
    </body>
</html>
