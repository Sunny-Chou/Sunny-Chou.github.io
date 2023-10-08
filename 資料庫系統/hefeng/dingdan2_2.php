<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>查看訂單</title>
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
            }else if(mysqli_fetch_array(mysqli_query( $con,"select * from 使用者 where 帳號='{$_SESSION['mc']}';"))){
                mysqli_close ( $con );
                echo "<script>window.location.href='employeeFunctionSelect.php'</script>";
            }
            $a = mysqli_query ( $con,"select * from 訂單 where 店家名稱='{$_SESSION['mc']}' and 訂單狀態=1;");
            $a1=mysqli_fetch_array($a);
            if($a1){
                echo "<header><h1>",$_SESSION['mc'],"訂單</h1></header><form name='form' method='post' action='dingdan3_3.php'><select name='a'>";
                while($a1){
                    echo "<option value='",$a1['訂單編號'],"'>",$a1['訂單編號'],"</option>";
                    $a1=mysqli_fetch_array($a);
                }
                echo "</select><br><input type='submit' value='選擇'>";
            }else{
                echo "<header><h1>",$_SESSION['mc'],"暫無已完成訂單</h1></header>";
            }
        ?>
        </form>
        <form name="form2" method="post" action="dingdan.php">
            <input type="submit" value="返回">
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>