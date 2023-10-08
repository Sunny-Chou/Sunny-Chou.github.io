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
    }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 店家 where 店家名稱='{$_SESSION['mc']}';"))){
        mysqli_close ( $con );
        echo "<script>window.location.href='clientFunctionSelect.php'</script>";
    }
    mysqli_close ( $con );
    ?>
    <section>
       <h1 class="page_title">合豐商行進貨與銷售系統</h1>
    </section>
    <section>
            <div class="selection">    
            <h2 style="text-align:center;font-size: 150%; color: Navy; font-family: 標楷體">功能選擇</h2>
            <input type="button" value="建立訂單" onclick="window.location.href='createOrder.php'">
            <br><br>
            <input type="button" value="查看商品庫存" onclick="window.location.href='chakan.php'">
            <br><br>
            <input type="button" value="備貨" onclick="window.location.href='beihuo.php'">
            <input type="button" value="補貨" onclick="window.location.href='buhuo.php'">
            <input type="button" value="進貨" onclick="window.location.href='jinhuo.php'">
            <input type="button" value="產線進貨" onclick="window.location.href='chanxian.php'">
            <input type="button" value="列印備貨單" onclick="window.location.href='lie.php'">
            <br><br>
            <input type="button" value="零售" onclick="window.location.href='lingshou.php'">
            <input type="button" value="派車" onclick="window.location.href='paiche.php'">
            <input type="button" value="店取" onclick="window.location.href='dianqu.php'">
            <input type="button" value="簽收" onclick="window.location.href='qianshou.php'">
            <input type="button" value="修改或刪除訂單" onclick="window.location.href='gaiorshan0.php';">
            <br><br>
            <input type="button" value="歷史零售資料" onclick="window.location.href='lingshous.php'">
            <input type="button" value="歷史產線進貨資料" onclick="window.location.href='chanxians.php'">
            <br><br>
            <input type="button" value="歷史宅配訂單資料" onclick="window.location.href='zhaipeis.php'">
            <input type="button" value="歷史店取訂單資料" onclick="window.location.href='dianqus.php'">
            <br><br>
            <input type="button" value="歷史補貨進貨資料" onclick="window.location.href='jinhuos.php'">
            <br><br>
            <input type="button" value="所有帳號" onclick="window.location.href='zhanghaos.php'">
            <br><br>
            <input type="submit" value="登出"onclick="window.location.href='index.html'">
            </div>
    </section>      
  </body>
  
</html>