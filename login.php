<?php
session_start();
print_r($_SESSION);
 // require_once('recaptchalib.php');
 //  $publickey = "6Ld2PvwSAAAAAEzz5yswXWgjZxYbshFvDAUZ6Mxb"; 
 //  // you got this from the signup page
 //  echo recaptcha_get_html($publickey);
$site_salt="ocguisalt";
$msg="";
$msgr="";
$msge="";
$emailin="";


  $db=  new SQLite3('user.db');

if(isset($_SESSION['fingerprint'])){ 
  header("Location:index.php"); 
}

 // echo " _get";
 // print_r($_GET);
 // echo "<br> _post";
 // print_r($_POST);

$emailin="";

$db = new SQLite3('user.db');
$sql = 'CREATE table IF NOT EXISTS userinfo (userID, email, password);';
$db->query($sql);


if (isset($_POST['login'])) {

  if (isset($_POST['email'])) 
    $emailform=$_POST['email'];

  if (''==$_POST['email'] || ''== $_POST['pass'])
  {
    $msg= $msg."<h5>Username/Password is empty.</h5>";

  }
  else
  {

   $passform=hash('sha256', $_POST['pass']);

   $stmt = $db->prepare('SELECT * FROM userinfo WHERE email=:id');
   $stmt->bindValue(':id', $_POST['email'], SQLITE3_TEXT);
   $result = $stmt->execute();
 
  // var_dump($result->fetchArray());
   // $sql->execute(array($_POST['email']));
   $n=0;
 
   while($r=$result->fetchArray())
   {
    // print_r($r);
    $n++;
    $passdb=$r['password'];
    // $p_salt=$r['psalt'];
    // $id=$r['id'];
    $emaildb=$r['email'];
    // $handle=$r['handle'];
   
  }



   if(0!=$n)
     {
       // $salted_hash = hash('sha256',$password.$site_salt.$p_salt);

       // if($p==$salted_hash)
        if($passdb==$passform)
       {
        $_SESSION['user']=$emaildb;
        $_SESSION['username']=$emaildb;
        $_SESSION['handle']=$emaildb;
        $fingerprint = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $_SESSION['last_active'] = time();
        $_SESSION['fingerprint'] = $fingerprint;
        header("Location:index.php");
       }
       else
       {
        $msg= $msg."<h5>Username/Password is Incorrect.</h5>";
       }


     }
    else
     {
      $msg= $msg."<h5>User is Unknown. Please Register</h5>";
     }


}

}

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
$msgr = "";

	if(1==$valid)
    {
    	
   		$sql2='SELECT * FROM userinfo WHERE email="'.$_POST['email'].'";';

      $result = $db->query($sql2);
 
      if($result->fetchArray() )
      {
        $msgr="Email exists, Please enter another valid email.";
        $valid=0;
      }
	}

$userID = "";

if(1==$valid)
  {



  
	 // $p_salt = rand_string(20);  http://subinsb.com/php-generate-random-string 
	 $salted_hash = hash('sha256', $_POST['pass']);



	 // $userID = md5(microtime("get_as_float"));
	 $email = $_POST['email'];
	 $password = $_POST['pass'];
	 $password = $salted_hash;

  $sql2 = 'INSERT into userinfo (userID, email, password) values 
  ("'
    .$userID.'", "' 
    .$email.'", "'
    .$password.'");
  ';
  // echo $sql2;
  $db->query($sql2);

}

}


 // function rand_string($length)
 //  {
 //  $str="";
 //  $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 //  $size = strlen($chars);
 //  for($i = 0;$i < $length;$i++)
 //  {
 //   $str .= $chars[rand(0,$size-1)];
 //  }
 //  return $str; /* http://subinsb.com/php-generate-random-string */
 //  }

$results = $db->query('SELECT * FROM userinfo;');

// $output = '
// <table border="5" style="width:640px;">';

// //table heading row
// $output .= '
// <tr class="bold">
// <td width=30px>Index</td>
// <td width=30px>User ID</td>
// <td width=30px>Email</td>
// <td width=30px>Password</td></tr>
// ';

//print query results
// $n=0;
// while ($row = $results->fetchArray())
//  {

// $class="";
//     //$sql1 = 'INSERT into newmessage (messageID, emailfrom, emailto, message, time, status, parent) values 

// if ($n%5==0)$class="dark";
// // $row["ext"]="gov";
// // $url="postmessage.php?replyto=".$row["messageID"];
// $output .=  '<tr><td  class="'.$class.'">'
//      .$n.'</td><td class="'.$class.'">'
//      .$row["userID"] .'</a></td><td class="'.$class.'">'
//      .$row["email"].'</td><td class="'.$class.'">'
//      .$row["password"].'</td></tr>

//      ';
//     $n++;

//   }
// $output .=  '</table>';

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


$output = "";

 
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
 background-color:rgba(255, 255, 153, 0.5);


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

<section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="form-wrap">
            <?php echo $msg; ?>
            <h4>Log in with your email</h4>

            <form role="form" action="login.php" method="post" id="login-form" autocomplete="off">
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                placeholder="somebody@example.com">
                
              </div>
                   <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="pass" id="pass1" class="form-control" placeholder="Password">
                        </div>
              <div class="form-group" >
                <label>
                  <input type="checkbox" id="checkbox1" value="option1" onclick="showPassword1()">
                  Show Password
                </label>
              </div>
            
              <div class="form-group" >
              <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block btn-primary" value="Log in">
              <input type="hidden" name="login" value="login">
                </div>
            </form>

          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>

<section id="register">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="form-wrap">
						<?php echo $msgr; ?>
					<h4>Register with your email account</h4>
					<form  id="register-form" role="form" action="login.php" method="POST">
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

echo $pre.$style.$output.$msgr.$body.$post;

?>