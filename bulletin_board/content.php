<?php

//idを取得
$title_id = $_GET['id'];

//共通関数
require('function.php');

if(!empty($_POST)){

  //変数に内容を代入
  $post_content = $_POST['post_content'];

  //内容
  if(empty($err_msg)){

    try{
      //DBへ接続
      $dbh = dbConnect();
      //SQL文作成
      $sql = 'INSERT INTO content (title_id,post_content) VALUES (:title_id,:post_content)';
      $data = array(':title_id' => $title_id,':post_content' => $post_content);

      //クエリ実行
      queryPost($dbh, $sql, $data);

      header('Location:' . $_SERVER['REQUEST_URI']); //同じページへ

    }catch (Exception $e){
      echo '取得できませんでした';
    }
  }

}

//内容のデータを検索
if(isset($_POST)){

  try{
    //DBへ接続
    $dbh = dbConnect();
    //SQL文作成
    $sql = "SELECT * FROM content WHERE title_id = $title_id";

    $stmtcontent = $dbh->query($sql);

  }catch(Exception $e){
    echo '取得できませんでした';
  }
}

//タイトルのデータを検索
if(isset($_POST)){

  try{
    //DBへ接続
    $dbh = dbConnect();
    //SQL文作成
    $sql = "SELECT * FROM title WHERE id = $title_id";

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
    <a href="index.php">
      <h1 class="header_title">掲示板</h1>
    </a>
</header>

<!-- タイトル表示 -->
<div class="title_name">
  <?php if(!empty($stmttitle)): ?>
    <?php foreach($stmttitle as $row): ?>
      <?php if(rtrim($row['id'] === $title_id)): ?>
        <h2 class="title_h2">「<?php echo $row['title_name']; ?>」</h2>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- 内容 -->
<div class="content">
<?php if(!empty($stmtcontent)): ?>
  <?php foreach($stmtcontent as $row): ?>
    <?php if(rtrim($row['title_id'] === $title_id)): ?>
      <p class="post_content"><?php echo $row['post_content']; ?>(<?php echo $row['posted_date']; ?>)</p>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
</div>

<!-- 内容フォーム -->
<form method="post" class="title_form">
  <textarea name="post_content" cols="50" rows="3" class="textarea"></textarea>
  <input type="submit" value="投稿" class="submit">
</form>
</body>
</html>