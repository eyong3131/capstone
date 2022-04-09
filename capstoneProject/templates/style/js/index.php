<?php
DATE_DEFAULT_TIMEZONE_SET('AFRICA/DAR_ES_SALAAM');
require_once('dbconnect.php');
error_reporting(~E_NOTICE);
session_start();
if (isset($_SESSION['user'])!="")
{
	header("Location:view.php");
	exit();
}
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
if(isset($_POST['login']))
{
$name=trim($_POST['name']);
$name=htmlspecialchars($_POST['name']);
$password=trim($_POST['password']);
$password=htmlspecialchars($_POST['password']);

$sth=$conn->prepare("SELECT * FROM users WHERE name=?");
$sth->execute(array(
$_POST['name'])
);
$row=$sth->fetch(PDO::FETCH_ASSOC);
$count=$sth->rowCount();
if($count == 1 || $count > 0 )
		{
if (password_verify($_POST['password'] , $row['password']))
{
    $_SESSION['user'] = $row['user_id'] ;
		header('location:view.php');
}
$user_status="online";
		$stmt =$conn->prepare('UPDATE users SET
user_status=:user_status WHERE user_id=:id');
$stmt->bindParam(':user_status',$user_status);
$stmt->bindParam(':id',$_SESSION['user']);
$stmt->execute();	
//$login_id = $stmt->lastInsertId();
/*$stmt=$conn->prepare( "SELECT * FROM users where user_id=:id") ;
$stmt->execute(['id'=>$id]);
	$row=$stmt->fetch(PDO::FETCH_BOTH);
	$count=$stmt->rowcount();
	*/
	//$_SESSION['user']==$row['user_id'];
	//$login_id = $stmt->lastInsertId();
	
	//$_SESSION['type']=$row['user_type'];
		
	$time_loged =date("Y-m-d H:i:s",strtotime("now"));
	$stmt=$conn->prepare('insert into activity(time_loged,user_id)VALUES(?,?)');
	$stmt->bindparam(1,$time_loged);
	$stmt->bindparam(2,$_SESSION['user']);
	$stmt->execute();
 //}
		}
 else
 {
	$_SESSION['msg']='something went wrong';
 }
}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--->
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
#ww{
position:relative;
top:200px;
}
</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-6 col-sm-push-3" id="ww">
<?php
	if(isset($_SESSION['msg']))
	{
			?>
<?php
echo $_SESSION['msg'];
	}
?>
            <?php
			unset($_SESSION['msg']);
		?>  
<form method="post" enctype="multipart/form-data" class="form-horizontal">
<label class="control-label"></label>
<div class="form-group">
<input type="text" class="form-control" name="name" required />
    </div>
<label class="control-label"></label>
<div class="form-group">
<input type="password" class="form-control" name="password" required />
</div>
<div class="form-group">
<button type="submit" class="btn btn-default" name="login">
<span class="glyphicon glyphicon-log-in">
</span>
</button>
<p class="text-danger" id="pp"><a href="register.php">click here to register</a></p>
</div> 






<script>
$(document).ready(function(){
<?php
if(isset($_SESSION["user"]))
{
?>
function update_user_activity()
{
 var action = 'update_time';
 $.ajax({
  url:"action.php",
  method:"POST",
  data:{action:action},
  success:function(data)
  {

  }
 });
}
setInterval(function(){ 
 update_user_activity();
}, 3000);


<?php
}
else
{
?>
fetch_user_login_data();
setInterval(function(){
 fetch_user_login_data();
}, 3000);
function fetch_user_login_data()
{
 var action = "fetch_data";
 $.ajax({
  url:"action.php",
  method:"POST",
  data:{action:action},
  success:function(data)
  {
   $('#user_login_status').html(data);
  }
 });
}
<?php
}
?>

});
</script>
</body>
</html>

        