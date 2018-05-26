<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

if(
	!isset($_POST['name'])||$_POST['name']=="" ||
	!isset($_POST['email'])||$_POST['email']=="" ||
	!isset($_POST['naiyou'])||$_POST['naiyou']=="" 
){
	exit('ParamError');
}

$name = $_POST['name'];
$email = $_POST['email'];
$naiyou = $_POST['naiyou'];


//2. DB接続します
try {    
$pdo=new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','5123'); 
} catch (PDOException $e) {    
exit( 'DbConnectError:' . $e->getMessage() ); 
}

  //データ登録SQL作成 
   $sql="INSERT INTO gs_an_table ( id, name, email, naiyou, indate ) VALUES( NULL, :a1, :a2, :a3, sysdate() )";

  $stmt = $pdo->prepare($sql);  
  $stmt->bindValue(':a1', $name,  PDO:: PARAM_STR);  
  $stmt->bindValue(':a2', $email,  PDO:: PARAM_STR);  
  $stmt->bindValue(':a3', $naiyou,  PDO:: PARAM_STR);//Integer（数値の場合 PDO::PARAM_INT)
  
   //SQL実⾏  
   $status = $stmt->execute(); 


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLエラー:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("location: index.php");


}
?>
