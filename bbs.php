<!DOCTYPE html>
<html lang='ja'>
<head>
	<meta charset="UTF-8">
	<title>セブ掲示板</title>

<!-- CCS -->
	  <link rel="stylesheet" href="assets/css/bootstrap.css">
	  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
	  <link rel="stylesheet" href="assets/css/form.css">
	  <link rel="stylesheet" href="assets/css/timeline.css">
	  <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      	<div class="container">
          	<!-- Brand and toggle get grouped for better mobile display -->
          	<div class="navbar-header page-scroll">
              	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  	<span class="sr-only">Toggle navigation</span>
                  	<span class="icon-bar"></span>
                  	<span class="icon-bar"></span>
                  	<span class="icon-bar"></span>
              	</button>
              	<a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-camera"></i> Oneline bbs -Photo & Football- <i class="fa fa-soccer-ball-o"></i></span></a>
          	</div>
          	<!-- /.navbar-collapse -->
      	</div>
      	<!-- /.container-fluid -->
 	</nav>

<div class="container">
    <div class="row">
		<form action="bbs.php" method="post">
			<div class="col-md-4 content-margin-top">
				<div class="form-group">
	            	<div class="input-group">
	            		<div class="timeline-label">
							<input type="text" name="nickname" class="form-control"　id="validate-text"　placeholder="nickname" required>
              				<span style=(float:left) class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>

						</div>
					</div>	
					<div class="input-group">
	            		<div class="timeline-label">
							<textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
			              	<span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
						</div>
					</div>
				</div>
			</div>
							<button type="submit" class="btn btn-warning col-xs-12">つぶやく</button> 
		</form>


	<?php
	//データベースに接続
	//issetと合わせて!emptyというのも使える
	if (isset($_POST['nickname'], $_POST['comment'])) 
	{
		$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
		$user = 'root';
		$password = '';

		// $dsn = 'mysql:dbname=LAA0685925-onelinebbs;host=mysql105.phy.lolipop.lan';
		// $user = 'LAA0685925';
		// $password = 'nexseed1204';

		$dbh = new PDO($dsn, $user, $password);
		$dbh->query('SET NAMES utf8');

			$nickname = $_POST['nickname'];
			$comment = $_POST['comment'];

		//SQL文作成（INSERT文）
		$sql='INSERT INTO `posts`(`nickname`, `comment`, `created`) VALUES("'.$nickname.'","'.$comment.'",now())';
		
		//INSERT文実行
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		echo '<br /><br /><br /><p>入力ありがとうございます。'."<span>$nickname</span>".'さん。投稿完了です。<p><br /><br />';

	  	?>
	  <div class="col-md-8 content-margin-top">
	  	<?php
		//一覧表を作成
		$sql = 'SELECT * FROM `posts` WHERE 1 order by `created` DESC';
		$stmt = $dbh -> prepare ($sql);
		$stmt ->execute();

	//	echo '<table border=1>';
	//	echo '<tr>';
	//		echo '<td width=20px>id</td>';
	//		echo '<td width=100px>nickname</td>';
	//		echo '<td width=300px>comment</td>';
	//		echo '<td width=200px>created</td>';
	//	echo '</tr>';
	//	echo '</table>';
?>

	<div class="timeline-centered">

<?php

			while(1){
				$rec = $stmt->fetch(PDO::FETCH_ASSOC);

					if($rec==false)
					{
						break;
					}
?>

		<article class="timeline-entry">
            <div class="timeline-entry-inner">
                <div class="timeline-icon bg-success">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-cogs"></i>
                </div>
	                <div class="timeline-label">
						<h2>
							<?php
								echo $rec['id'];
								echo $rec['nickname'];
								echo $rec['comment'];
								echo $rec['created'];
								echo '<br />';
							?>
						</h2>
					</div>
			</div>
		</article>
<?php	}	?>


<?php				
				
	//			echo '<table border=1>';
	//			echo '<tr>';
	//				echo '<td width=20px>'.$rec['id'].'</td>';
	//				echo '<td width=100px>'.$rec['nickname'].'</td>';
	//				echo '<td width=300px>'.$rec['comment'].'</td>';
	//				echo '<td width=200px>'.$rec['created'].'</td>';
	//				echo '<br />';
	//			echo '</tr>';	
	//			echo '</table>';
	//			echo '</table>';
	}

?>

<?php
	//データベースから切断
	$dbh=null;
?>

				<article class="timeline-entry begin">

				    <div class="timeline-entry-inner">

				        <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
				            <i class="entypo-flight"></i> +
				        </div>

				    </div>

				</article>
		</div>
	　　</div>	
	</div>
<!-- </div> -->
<!--	<h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:20</span></h2>
	<p>つぶやきコメント</p>

	<h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
	<p>つぶやきコメント2</p>
-->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>


</body>
</html>