<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>補貨</title>
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
            div{
                text-align: center;
            }
        </style>
    </head> 
    <body>
    <main>
        <header>
            <h1>補貨廠商</h1>
        </header>
        <form name="form" method="post" action="buhuo2.php">
        <select name="pai"><option value="派車補貨">派車補貨</option><option value="到店補貨">到店補貨</option></select><br>
        <select name="mc">
            <option>選擇補貨廠商</option>
            <?php
            session_start ();
            if(!$_SESSION['mc']){
                echo "<script>window.location.href='index.html'</script>";
            }
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
            $mc = mysqli_query ( $con,"select * from 店家 where streamflag=1 and 店家名稱!='合豐商行';");
            $mcs=mysqli_fetch_array($mc);
            while($mcs){
                echo "<option value='",$mcs['店家名稱'],"'>",$mcs['店家名稱'],"</option>";
                $mcs=mysqli_fetch_array($mc);
            }
            ?>
        </select><br>
        <input type="submit" value="補貨">
        </form>
        <form name="form2" method="post" action="employeeFunctionSelect.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>