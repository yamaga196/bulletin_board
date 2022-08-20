<?php

//共通関数
require('function.php');

//post送信された場合
if(!empty($_POST)){

  //変数にユーザー情報を代入
  $title_name = $_POST['title_name'];


  //掲示板のデータ
    if(empty($err_msg)){

      try{
        //DBへ接続
        $dbh = dbConnect();
        //SQL文作成
        $sql = 'INSERT INTO title (title_name) VALUES (:title_name)';
        $data = array(':title_name' => $title_name);
  
        //クエリ実行
        queryPost($dbh, $sql, $data);
  
        header('Location: ' . $_SERVER['SCRIPT_NAME']); //同じページへ
  
      }catch (Exception $e){
        echo '接続できませんでした';
      }
    }
}

//掲示板の検索
if(isset($_POST)){
  try{
    //DBへ接続
    $dbh = dbConnect();
    //SQL文作成
    $sql = 'SELECT * FROM title ORDER BY id DESC';

    $stmttitle = $dbh->query($sql);

  }catch(Exception $e){
    echo '取得できませんでした';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="sanitize.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Document</title>
</head>
<body>
  <header class="header">
    <h1 class="header_title">掲示板</h1>
  </header>

  <div class="title">
    <?php if(!empty($stmttitle)): ?>
      <?php foreach($stmttitle as $row): ?>
        <a href="content.php?id=<?php echo $row['id']; ?>"><?php echo $row['title_name']; ?></a>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>

  <form method="post" class="title_form">
    <input class="input" type="text" name="title_name">
    <input class="submit" type="submit" value="掲示板を作る">
  </form>

</body>
</html>