<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>歷史宅配訂單資料</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                max-width: 960px;		
                margin: 0 auto; 
                padding: 0px;
                color:navy;
            }
            header{
                text-align: center;
                color:white;
                background-color: navy;
            }
            main{
                width:100%;
                text-align: center;
                font-family: 標楷體;
                background-color: AliceBlue;
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
    <main>
        <header>
            <h1>選擇宅配訂單建立日期</h1>
        </header>
        <form name="form" method="post" action="zhaipeis2.php">
            <?php echo"<input type='date' name='d' id='d'value='",date("Y-m-d", time()+7*60*60),"' max='",date("Y-m-d", time()+7*60*60),"'>"?>
            <br><input type="submit" value="選擇">
        </form>
        <form name="form2" method="post" action="employeeFunctionSelect.php">
            <input type="submit" value="返回">
        </form>
    </main>
</body> 
</html>