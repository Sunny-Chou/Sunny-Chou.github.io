<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>進貨</title>
        <style>
            body {
                width: 100%;
                height: 100%;
                max-width: 960px;		
                margin: 0 auto; 
                padding: 0px;
                font-family: 標楷體;
                color:navy;
            }
            main{
                width:100%;
                text-align: left;
                background-color: AliceBlue;
            }
            header{
                text-align: center;
                color:white;
                background-color: navy;
            }
            p{
                display: inline-block;
            }
        </style>
    </head> 
    <body>
        <main>
            
            <form name="form" method="post" action="chakan.php">
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
            if(isset($_POST['a'])){
                if(mysqli_fetch_array(mysqli_query( $con,"select * from 補貨單 where 補貨單編號='{$_POST['a']}';"))['車牌']){
                    $che=mysqli_fetch_array(mysqli_query( $con,"select * from 補貨單 where 補貨單編號='{$_POST['a']}';"))['車牌'];
                    mysqli_query( $con,"update 貨車 set 派車狀態=0 where 車牌='{$che}';");
                }
                mysqli_query( $con,"update 補貨單 set 補貨單狀態=1,進貨的帳號='{$_SESSION['mc']}' where 補貨單編號='{$_POST['a']}';");
                $b=mysqli_query( $con,"select * from 商補 where 補貨單編號='{$_POST['a']}';");
                $bs=mysqli_fetch_array($b);
                while($bs){
                    $u=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$bs['商品名稱']}' and 規格='{$bs['規格']}' and 單位='{$bs['單位']}';"))['庫存數量']+$bs['補貨商品數量'];
                    mysqli_query($con,"update 商品 set 庫存數量='{$u}' where 商品名稱='{$bs['商品名稱']}' and 規格='{$bs['規格']}' and 單位='{$bs['單位']}';");
                    $bs=mysqli_fetch_array($b);
                }
            }
            
            echo "<script>form.submit();</script>";
        ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 
</body> 
</html>