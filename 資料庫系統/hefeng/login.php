<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>使用者登入</title>
        <script src="sources/jquery-1.9.1.js"></script>
        <script src="sources/jquery-form.js"></script>
        <style>
          body, div, span{
	          margin: 0;
          	padding: 0;
	           /*font-size: 100%;*/
            z-index: 0;
          }

           .page_title	{
          	text-align:center;
            font-size: 250%;
            color: Navy; 
            font-family: 標楷體;
            z-index: 1;
            } 

        .login_account {
        	width:600px;
        	height:450px;
        	position: absolute;
	       top:40%;
	       left: 50%;
	       margin: -120px 0 0 -300px;
	       border-radius: 15px;
	       vertical-align: middle;
          background-color: AliceBlue;
        	text-align:center;
        	font-size: 125%;
          z-index: 1;
          }
        </style>
    </head>
    <body style="background-color:LightSteelBlue;">
        <section>
            <h1 class="page_title">合豐商行進貨與銷售系統</h1>
        </section>
        <section>
            <div class="login_account">    
                <h2 style="text-align:center;font-size: 150%; color: Navy; font-family: 標楷體">登入帳號</h2>         
                <form action = "login.php" method = "POST">
                    <input type = "text" name = "username" required style="padding:6px;border-radius:5px; border:solid;border-color:#ffffff;"><br><br>
                    <input type = "password" name = "password" required style="padding:6px;border-radius:5px; border:solid;border-color:#ffffff;"><br><br>
                    <input type="submit" value="登入" style="padding:6px;border-radius:5px;border: none"><br><br>
                </form>
            </div>  
        </section>

	<?php
	session_start();

	//$_POST使用者名稱和密碼
	$username = "";
	if (isset($_POST["username"])){
    	$username = $_POST["username"];
	}
	$password = "";
	if (isset($_POST["password"])){
    	$password = $_POST["password"];
	}
	//連線mysql
	$link = mysqli_connect('localhost','root',null, 'hefeng');
	//驗證mysql連線是否成功
	if(mysqli_errno($link)){
		echo "連線mysql失敗：".mysqli_error($con);
		exit;
	}

	//執行
	$result = mysqli_query($link,"SELECT * FROM 使用者 WHERE 帳號='$username' and 密碼='$password'");
	$employee = mysqli_num_rows($result); 
	$result2 = mysqli_query($link,"SELECT * FROM 店家 WHERE 帳號='$username' and 密碼='$password'");
	$client = mysqli_num_rows($result2); 
	if($employee){
		echo "<script>alert('登入成功');</script>";
		$row = mysqli_fetch_array($result);
		$_SESSION['mc'] = $row['帳號']; // session
		echo "<script>window.location.href = 'employeeFunctionSelect.php'</script>";
	}else if($client){
		echo "<script>alert('登入成功');</script>";
		$row = mysqli_fetch_array($result2);
		$_SESSION['mc'] = $row['店家名稱']; // session
		echo "<script>window.location.href = 'clientFunctionSelect.php'</script>";
	}
	
	
	
	mysqli_close($link);
	
?>
    </body>
</html>


