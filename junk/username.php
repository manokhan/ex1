<?php

$db = new SQLite3('user.db');
$sql = 'CREATE table IF NOT EXISTS username (userID, email, password);';
$db->query($sql);

if(isset($_POST['register']))
{
 
    $valid=1;
   if(!isset($_POST['email']) || !isset($_POST['pass']))
   {
      $msgr="Please enter valid email and password.";
      $valid=0;
   }
   
   if (1==$valid)
   	   {
	   		if(''==$_POST['email'] || ''==$_POST['pass'])
	   		{
	     		$msgr="Please enter valid email and password.";
	    		$valid=0;
	   		}
	   	}	
$userID = "";
$email = "";
$password = "";

  $sql2 = 'INSERT into username (userID, email, password) values 
  ("'
    .$userID.'", "' 
    .$email.'", "'
    .$password.'");
  ';
  echo $sql2;
  $db->query($sql2);
}

$results = $db->query('SELECT * FROM username;');

$output = '
<table border="5" style="width:640px;">';

//table heading row
$output .= '
<tr class="bold">
<td width=30px>User ID</td>
<td width=30px>Email</td>
<td width=30px>Password</td></tr>
';

//print query results
$n=0;
while ($row = $results->fetchArray())
 {

$class="";
    //$sql1 = 'INSERT into newmessage (messageID, emailfrom, emailto, message, time, status, parent) values 

if ($n%5==0)$class="dark";
// $row["ext"]="gov";
// $url="postmessage.php?replyto=".$row["messageID"];
$output .=  '<tr><td  class="'.$class.'">'
     .$n.'</td><td class="'.$class.'">'
     .$row["userID"] .'</a></td><td class="'.$class.'">'
     .$row["email"].'</td><td class="'.$class.'">'
     .$row["password"].'</td></tr>

     ';
    $n++;

  }
$output .=  '</table>';

    // if(1==$valid)
    // {
   
   	// 	$stmt = $dbh->prepare("SELECT *  FROM users WHERE username=:uname");
   	// 	$stmt->bindValue(':uname', $_POST['email'], SQLITE3_TEXT);
   	// 	$result = $stmt->execute();

    //   if($result->fetchArray() )
    //   {
    //     $msgr="Email exists, Please enter another valid email.";
    //     $valid=0;
    //   }
    // }




 
$pre = ' <!DOCTYPE html>
<html>
<head>
    <title>USER LOGIN</title>
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">


     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
';

$style ='<style >
body{
  font-family:sans-serif;
  font-size:10px;
 background-color:rgba(255, 255, 153, 1);


}
table  {
  font-family: verdana,arial,sans-serif;
  font-size:12px;
  color:rgba(0, 51, 0, 1);
  border-width: 1px;
  border-color: #000000;/* ?????*/
  border-collapse: collapse;

}
 
table  td {
  border-width: 0px;
  padding: 4px;
  border-style: solid;
  border-color: #CCCCCC;
  background-color:rgba(153, 204,255,1);
  overflow:hidden;
}

.dark {
  background-color: rgba(255, 255,153,1);
}

.bold {
  font-size:11px;
  font-weight:bold;
}


</style>';

$body = ' <body>

<section id="register">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-wrap">
						<?php echo $msgr; ?>
					<h4>Register with your email account</h4>
					<form  id="register-form" role="form" action="username.php" method="POST">
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
						</div>
						<div class="form-group">
							<label for="key" class="sr-only">Password</label>
							<input type="password" name="pass" id="pass2" class="form-control" placeholder="Password">
						</div>
						<div class="form-group" >
							<label>
								<input type="checkbox" id="checkbox2" value="option1" onclick="showPassword2()">
								Show Password
							</label>
						</div>           

						<div class="form-group" >
						<input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block  btn-primary" value="Register">
						<input type="hidden" name="register" value="register">
						</div>
					</form>
				</div>
			</div> <!-- /.col-xs-12 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</section>
';


$post =" </body>
</html>
";

echo $pre.$style.$output.$body .$post;

?>