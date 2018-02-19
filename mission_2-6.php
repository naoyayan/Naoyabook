<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>

<script language="JavaScript">
function rCheck()
{
if (window.name != "2thwindow")
{
location.reload();
window.name = "2thwindow";
}
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Cache-Control" content="no-cache">

<link rel="stylesheet" type="text/css" href="/style.css">

<title>NaoyaBook</title>

</head>
<body>

<!-- コンテナ開始 -->
<div id="container">

<!-- ページ開始 -->
<div id="page">

<!-- ヘッダ開始 -->
<div id="header">

<h1 class="siteTitle">NaoyaBook</h1>

<p class="catch"><strong>アニメ好きによるアニメ好きのためのアニメチャンネル</strong></p>

<ul class="nl clearFix">
<li class="active"><a href="type1_design2_top.html">ホーム</a></li>
<li><a href="type1_design2_low.html">みんなのおすすめ</a></li>
<li><a href="#">ランキング</a></li>
<li><a href="#">あにめったー</a></li>
<li><a href="#">ミニゲーム</a></li>
<li><a href="#">お問い合わせ</a></li>
</ul>

<hr class="none">

</div>
<!-- ヘッダ終了 -->


<!-- コンテンツ開始 -->
<div id="content">


<!-- メインカラム開始 -->
<div id="main">


<div class="section normal update">

<div class="heading">
<h2>みんなの好きなアニメ</h2>
</div>

 <?php
 
  //文字化け対策
  header('Content-Type: text/html; charset=UTF-8');
  
//番号<>名前<>時間<>パスワード<>コメントの順に保存する。
		//hiddenの初期値を設定。これが0なら新規書き込み。1なら編集。
		if(empty($hidden)){$hidden = 0;}
		
		//新規書き込み
		if(!empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["comment"]) && $_POST["hidden"]==0){
			$textfile = "kadai_2-6.txt";
			$count= count(file("kadai_2-6.txt")) +1;
			$time = date("Y/m/d/D H:i:s",time());
			$_POST["password"] = hash('sha256', $_POST["password"]);
			$fp = fopen($textfile, 'a');
			fwrite($fp, $count."<>".$_POST["name"]."<>".$time."<>".$_POST["password"]."<>".$_POST["comment"]."\n");
			fclose($fp);
		}
		//新規書き込みの例外処理。名前が入ってない。
		else if(empty($_POST["name"]) && !empty($_POST["password"]) && !empty($_POST["comment"]) && $_POST["hidden"]==0){
			echo "<script>alert('Please write your Name');</script>";
		}
		//新規書き込みの例外処理。パスワードが入ってない。
		else if(!empty($_POST["name"]) && empty($_POST["password"]) && !empty($_POST["comment"]) && $_POST["hidden"]==0){
			echo "<script>alert('Please write your Password');</script>";
		}
		//新規書き込みの例外処理。コメントが入ってない。
		else if(!empty($_POST["name"]) && !empty($_POST["password"]) && empty($_POST["comment"]) && $_POST["hidden"]==0){
			echo "<script>alert('Please write your Comment');</script>";
		}

		//削除
		if(!empty($_POST["DeleteNo"]) && !empty($_POST["DeletePass"])){
			$deletepass = hash('sha256', $_POST["DeletePass"]);
			$textfile = "kadai_2-6.txt";
			$checkcounter = 0;
			$fp = fopen($textfile, 'r+');
			$hairetsu = file("kadai_2-6.txt");
			foreach($hairetsu as $value){
				$explotion = explode("<>", $value,5);
				if($explotion[0]==$_POST["DeleteNo"] && $explotion[3]==$deletepass){
					$explotion[1] = '名無しさん';
					$explotion[4] = '(このコメントは破壊されました)';
					$implotion = implode("<>", $explotion)."\n";
					fwrite($fp, $implotion);
					$checkcounter = 1;
				}
				else{
					$implotion = implode("<>", $explotion);
					fwrite($fp, $implotion);
				}
			}
			fclose($fp);
			if($checkcounter==0){
				echo "<script>alert('You have wrong Number or Password');</script>";
			}
		}
		//削除の例外処理。番号が入ってない。
		else if(empty($_POST["DeleteNo"]) && !empty($_POST["DeletePass"])){
			echo "<script>alert('Please write your Number');</script>";
		}
		//削除の例外処理。パスワードが入ってない。
		else if(!empty($_POST["DeleteNo"]) && empty($_POST["DeletePass"])){
			echo "<script>alert('Please write your Password');</script>";
		}

		//編集の第一段階。番号とパスワードを確認してブラウザに表示する。hiddenの値を1にする。
		if(!empty($_POST["EditNo"]) && !empty($_POST["EditPass"]) && $_POST["hidden"]==0){
			$editpass = hash('sha256', $_POST["EditPass"]);
			$textfile = "kadai_2-6.txt";
			$checkcounter = 0;
			$fp = fopen($textfile, 'r');
			$hairetsu = file("kadai_2-6.txt");
			foreach($hairetsu as $value){
				$explotion = explode("<>", $value,5);
				if($explotion[0]==$_POST["EditNo"] && $explotion[3]==$editpass){
					$editno = $explotion[0];
					$editname = $explotion[1];
					$editcomment = $explotion[4];
					$hidden = 1;
					$checkcounter = 1;
				}
			}
			fclose($fp);
			if($checkcounter==0){
				echo "<script>alert('You have wrong Number or Password');</script>";
			}
		}
		//編集の第二段階。txtファイルに書き込む。
		if(!empty($_POST["name"]) && !empty($_POST["comment"]) && $_POST["hidden"]==1){
			$textfile = "kadai_2-6.txt";
			$checkcounter = 0;
			$fp = fopen($textfile, 'r+');
			$hairetsu = file("kadai_2-6.txt");
			foreach($hairetsu as $value){
				$explotion = explode("<>", $value,5);
				if($explotion[0]==$_POST["editno"]){
					$explotion[1] = $_POST["name"];
					$explotion[4] = $_POST["comment"];
					$implotion = implode("<>", $explotion)."\n";
					fwrite($fp, $implotion);
					$checkcounter = 1;
				}
				else{
					$implotion = implode("<>", $explotion);
					fwrite($fp, $implotion);
				}
			}
			fclose($fp);
			$hidden = 0;
		}
		//編集の例外処理。名前が入ってない。
		else if(empty($_POST["name"]) && !empty($_POST["comment"]) && $_POST["hidden"]==1){
			echo "<script>alert('Please write your Name');</script>";
			$hidden = 0;
		}
		//編集の例外処理。コメントが入ってない。
		else if(!empty($_POST["name"]) && empty($_POST["comment"]) && $_POST["hidden"]==1){
			echo "<script>alert('Please write the Comment');</script>";
			$hidden = 0;
		}
		
		$textfile = "kadai_2-6.txt";
			fclose(fopen($textfile, 'a'));
			$hairetsu = file("kadai_2-6.txt");
			foreach($hairetsu as $value){
				$explotion = explode("<>", $value,5);
				echo $explotion[0]." :".$explotion[1]." ".$explotion[2]."<br>".$explotion[4]."<br><br>";
			}
	?>

</div>

</div>
<!-- メインカラム終了 -->


<!-- サイドバー開始 -->
<div id="nav">

<div class="section emphasis">

<div class="heading">
<h2>コメント投稿</h2>
</div>

<form action="mission_2-6.php" method="post">

			<input type="hidden" name="editno" value="<?php echo $editno; ?>">
			なまえ<br>
			<input type="text" name="name" value="<?php echo $editname; ?>"><br>
			こめんと<br>
			<input type="text" name="comment" value="<?php echo $editcomment; ?>"><br>
			ぱすわーど<br>
			<input type="password" name="password"><br>
			<input type="hidden" name="hidden" value="<?php echo $hidden; ?>">
			<input type="submit" value="とうこう"><br><br>

</form>

</div>

<div class="section strong">

<div class="heading">
<h2>コメント編集</h2>
</div>

<form action="mission_2-6.php" method="post">

			へんしゅうするばんごう<br>
			<input type="text" name="EditNo"><br>
			せっていしたぱすわーど<br>
			<input type="password" name="EditPass"><br>
			<input type="submit" value="へんしゅう"><br><br>

</form>

</div>

<div class="section normal">

<div class="heading">
<h2>コメント削除</h2>
</div>

<form action="mission_2-6.php" method="post">

けしたいこめんとのばんごう<br>
<input type="text" name="DeleteNo"><br>
せっていしたぱすわーど<br>
<input type="password" name="DeletePass"><br>
<input type="submit" value="さくじょ"><br><br>

</form>

</div>

</div>
<!-- サイドバー終了 -->


<hr class="clear">

</div>
<!-- コンテンツ終了 -->


<!-- フッタ開始 -->
<div id="footer">


</div>
<!-- フッタ終了 -->


</div>
<!-- ページ終了 -->

</div>
<!-- コンテナ終了 -->

</body>
</html>
