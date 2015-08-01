<?php
session_start();
// print_r($_SESSION);
// echo "<br>";
// print_r($_POST); 
// echo "<br>";
// print_r($_GET);
// echo "<br>";
// print_r($_SERVER);
// die();

$fingerprint = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);

if (!isset($_SESSION['user']))
{
    setcookie(session_name(), '', time()-3600, '/');
    session_destroy();
    header("Location:login.php");
    die();
}
session_regenerate_id(); 
$_SESSION['last_active'] = time();
$_SESSION['fingerprint'] = $fingerprint;
print_r($_SESSION);

$email =  $_SESSION['user'] ;

 // echo " _get";
 // print_r($_GET);
 // echo "<br> _post";
 // print_r($_POST);
 

date_default_timezone_set("America/Los_Angeles");
// $datestring =  date("c");

$db = new SQLite3('todo.db');

$sql = 'CREATE table IF NOT EXISTS todolist (indexnumber, email, timedate, title, status);';

$db->query($sql);

$message = "";


if (isset($_POST['add'])) 
{
  echo ""
  ."message: ".$_POST['message']."<br>"
  ."add: ".$_POST['add']."<br>"
  ;
  $message = $_POST['message'];

  $indexnumber = md5(microtime("get_as_float"));
  $status = "checked";
  
  // $timedate = microtime("get_as_float");
  $timedate = date("c");

 $sql2 = 'INSERT into todolist (indexnumber, email, timedate, title, status) values 
  ("'
    .$indexnumber.'", "'
    .$email.'", "' 
    .$timedate.'", "' 
    .$message.'", "'
    .$status.'");
  ';
 
  echo $sql2;
  $db->query($sql2);

}
// $string1 = 'gta"gsyd "'.$email.'" fsfsfs';
// echo $string1;
echo "<br>";

$sql1 = 'SELECT * FROM todolist where email = "'.$email.'";';
echo $sql1;

$results = $db->query($sql1);

$output = '
<table border="5" style="width:640px;">';

//table heading row
$output .= '
<tr class="bold">
<td width=30px>n</td>
<td width=30px>indexnumber</td>
<td width=30px>email</td>
<td width=30px>timedate</td>
<td width=30px>title</td>
<td width=30px>status</td></tr>
';

//print query results
$n=0;
while ($row = $results->fetchArray())
 {

$class="";
    //$sql1 = 'INSERT into newmessage (messageID, emailfrom, emailto, message, time, status, parent) values 

if ($n%5==0)$class="dark";

$output .=  '<tr><td  class="'.$class.'">'
     .$n.'</td><td class="'.$class.'">'
     .$row["indexnumber"] .'</a></td><td class="'.$class.'">'
     // .'<a href="'.$url.'">'
     .$row["email"].'</td><td class="'.$class.'">'
     .$row["timedate"].'</td><td class="'.$class.'">'
    .$row["title"].'</td><td class="'.$class.'">'
     .$row["status"].'</td></tr>

     ';
    $n++;

  }
$output .=  '</table>';

$pre=' <!DOCTYPE html>
<html>
<head>
<title>To_Do_List</title>

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

  <section id="login">
    <div class="">
      <div class="">
        <div class="">
          <div class="">
            <?php echo $msg; ?>
            <h4>Check Message</h4>

            <form role="form" action="index.php" method="post" id="login-form" autocomplete="off">


              <div class="">
                <label for="key" class="">Message</label><br>
                 <textarea name="message" id="message" class="" placeholder="enter text">'.$message.'</textarea>
              </div>
              <div class="" >
              <br>
                <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block btn-primary" value="Add">
                <input type="hidden" name="add" value="add">
              </div>
            </form>

          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>
';
$post="</body>
</html>";

echo $pre.$style.$output.$body .$post;

?>
 
<style>
    html, body {
        display:block;
        width:100%;
        height:100%;
        margin:0;
        padding:0;
        font-family: helvetica neue,sans-serif;
        font-size: 10px;

    }

a{
text-decoration: none;

}
.btn{
    margin:20px;
 width:120px;
 padding:16px;
 text-align: center;
 line-height: 20px;
 font-size: 20px;
 border-radius: 8px;
 cursor: pointer;

}


.btn a {
color:#fff;

}

.btn-2{
    color:#fff;
   background-color: rgba(100,160, 240, 0.8 );


}

.btn-2:hover{
      background-color: rgba(0,60, 140, 0.8 );

}


.btn-primary{
    color:#fff;
   background-color: rgba(100,160, 240, 0.8 );


}

.btn-primary:hover{
      background-color: rgba(0,60, 140, 0.8 );

}

</style>

 

<body>



        
    <a href="index.php"> <div class="btn btn-2"> Go to mapas
        </div></a>

 <a href="logout.php"><div class="btn btn-primary">
   
Logout</div></a>
 <div class="btn btn-2">
    <?php
print_r($_SESSION);

    ?>
 </div>
           
<?php echo($_SESSION["handle"]); ?>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>



<div  id="dl" style="position:absolute; left:0px; bottom:120px; top:0px; ">
</div>

<script>


$( document ).ready(function() 
{
 $(document).on("click", "#searchbutton", function(){submitsearch("#searchr");});

}
</script>    

