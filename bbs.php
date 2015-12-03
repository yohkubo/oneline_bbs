<!DOCTYPE html>
<html lang='ja'>
<head>
	<meta charset="UTF-8">
	<title>セブ掲示板</title>

</head>
<body>
	<form action="bbs.php" method="post">
		<input type="text" name="nickname" placeholder="nickname" required>
		<textarea type="text" name="comment" placeholder="comment" required></textarea>
		<button type="submit">つぶやく</button> 
	</form>

<?php

//データベースに接続
//issetと合わせて!emptyというのも使える
if (isset($_POST['nickname'], $_POST['comment'])) 
{
	$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->query('SET NAMES utf8');

		$nickname = $_POST['nickname'];
		$comment = $_POST['comment'];

	//SQL文作成（INSERT文）
	$sql='INSERT INTO `posts`(`nickname`, `comment`, `created`) VALUES("'.$nickname.'","'.$comment.'",now())';
	
	//INSERT文実行
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	echo '入力ありがとうございます。'."<span>$nickname</span>".'さん。投稿完了です。<br /><br />';

	//一覧表を作成
	$sql = 'SELECT * FROM `posts` WHERE 1';
	$stmt = $dbh -> prepare ($sql);
	$stmt ->execute();

	echo '<table border=1>';
	echo '<tr>';
		echo '<td width=20px>id</td>';
		echo '<td width=100px>nickname</td>';
		echo '<td width=300px>comment</td>';
		echo '<td width=200px>created</td>';
	echo '</tr>';
//	echo '</table>';

		while(1){
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			if($rec==false)
			{
				break;
			}

//			echo $rec['id'];
//			echo $rec['nickname'];
//			echo $rec['comment'];
//			echo $rec['created'];
//			echo '<br />';
			
//			echo '<table border=1>';
			echo '<tr>';
				echo '<td width=20px>'.$rec['id'].'</td>';
				echo '<td width=100px>'.$rec['nickname'].'</td>';
				echo '<td width=300px>'.$rec['comment'].'</td>';
				echo '<td width=200px>'.$rec['created'].'</td>';
//				echo '<br />';
			echo '</tr>';	
//			echo '</table>';
			}
			echo '</table>';
}
	//データベースから切断
	$dbh=null;

?>
<!--	<h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:20</span></h2>
	<p>つぶやきコメント</p>

	<h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
	<p>つぶやきコメント2</p>
-->
</body>
</html>