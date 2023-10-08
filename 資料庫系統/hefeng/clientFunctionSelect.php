<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>功能選擇</title>
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
    
            .selection {
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
          .button {
            font-size:20pt;
             width:150px;
             height:100px;
             color:#000000;
          }
	</style>
  </head>
  <body>
    <?php
    session_start ();
    $con = mysqli_connect ( "localhost", "root", ""); 
    if (! $con) { 
        die ( '資料庫連線失敗' . $mysql_error()); 
    }
    mysqli_select_db ( $con,"hefeng");
    if(!$_SESSION['mc']){
        mysqli_close ( $con ); 
        echo "<script>window.location.href='index.html'</script>";
    }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 使用者 where 帳號='{$_SESSION['mc']}';"))){
        mysqli_close ( $con );
        echo "<script>window.location.href='employeeFunctionSelect.php'</script>";
    }
    mysqli_close ( $con );
    ?>
    <section>
       <h1 class="page_title">合豐商行進貨與銷售系統</h1>
    </section>
    <section>
            <div class="selection">    
            <h2 style="text-align:center;font-size: 150%; color: Navy; font-family: 標楷體">功能選擇</h2>
            <input type="button" value="建立訂單" onclick="window.location.href='createOrder2.php'">
            <input type="button" value="查看訂單" onclick="window.location.href='dingdan.php'">
            <input type="button" value="修改或刪除訂單" onclick="window.location.href='gaiorshan.php'">
            <br><br>
            <input type="submit" value="登出"onclick="window.location.href='index.html'">
            </div>
    </section>      
  </body>
  
</html>