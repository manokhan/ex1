<?php
$fingerprint = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
session_start();
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

?><!DOCTYPE html>
<html>
<head>
    <title>ag2</title>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js"></script>


</head>
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
