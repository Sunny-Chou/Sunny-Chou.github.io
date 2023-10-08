<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>店取</title>
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
        <main>
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
            if(!isset($_POST['mc'])){
                mysqli_close ( $con );
                echo "<script>window.location.href='dianqu.php'</script>";
            }
            if($_POST['mc']=='選擇店家'){
                $mc = mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=1 and 訂單狀態=0 and 配送方式=0;");
                $mcs=mysqli_fetch_array($mc);
                if($mcs){
                    echo "<header><h1>全部店家訂單</h1></header><form name='form' method='post' action='dianqu3.php'><select name='a'>";
                }else{
                    echo "<header><h1>暫無店取訂單</h1></header>";
                }
                while($mcs){
                    echo "<option value='",$mcs['訂單編號'],"'>",$mcs['訂單編號'],"</option>";
                    $mcs=mysqli_fetch_array($mc);
                }
                if(mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=1 and 訂單狀態=0 and 配送方式=0;"))){
                    echo "</select><br><input type='submit' value='選擇'></form>";
                }
            }else{
                $mc = mysqli_query ( $con,"select * from 訂單 where 店家名稱='{$_POST['mc']}' and 訂單備貨狀態=1 and 訂單狀態=0 and 配送方式=0;");
                $mcs=mysqli_fetch_array($mc);
                if($mcs){
                    echo "<header><h1>",$_POST['mc'],"店取</h1></header><form name='form' method='post' action='dianqu3.php'><select name='a'>";
                }else{
                    echo "<header><h1>暫無店取訂單</h1></header>";
                }
                while($mcs){
                    echo "<option value='",$mcs['訂單編號'],"'>",$mcs['訂單編號'],"</option>";
                    $mcs=mysqli_fetch_array($mc);
                }
                if(mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 店家名稱='{$_POST['mc']}' and 訂單備貨狀態=1 and 訂單狀態=0 and 配送方式=0;"))){
                    echo "</select><br><input type='submit' value='選擇'></form>";
                }
            } 
            ?>
            <form name="form2" method="post" action="dianqu.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>