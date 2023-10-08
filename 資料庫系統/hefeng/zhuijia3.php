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
                display: inline-block;
            }
        </style>
    </head> 
    <body>
    <main>
        <form name="form" method="post" action="qianshou2.php">
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
                $g=mysqli_query( $con,"select * from 商品;");
                $gs=mysqli_fetch_array($g);
                $j=true;
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        $j=false;break;
                    }
                    $gs=mysqli_fetch_array($g);
                }
                if($j){
                    echo "<script>alert('沒有選擇任何商品！');</script>";
                    echo "<script>window.location.href='qianshou.php'</script>";
                }
                $g=mysqli_query( $con,"select * from 商品;");
                $gs=mysqli_fetch_array($g);
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        if(!mysqli_fetch_array(mysqli_query($con,"select * from 追加商品 where 訂單編號='{$_POST['a']}' and 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))){
                            $n=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))['庫存數量']-$_POST[$gn];
                            if($n<0){
                                echo "<script>alert('商品庫存不足！');</script>";
                                echo "<script>window.location.href='buhuo.php'</script>";
                            }
                            $n=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))['庫存數量']-$_POST[$gn];
                            mysqli_query($con,"update 商品 set 庫存數量='{$n}' where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'");
                            mysqli_query($con,"insert into 追加商品 values('{$_POST['a']}','{$gs['商品名稱']}','{$gs['規格']}','{$gs['單位']}','{$_POST[$gn]}');");
                        }else{
                            $n=mysqli_fetch_array(mysqli_query($con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))['庫存數量']-$_POST[$gn]+mysqli_fetch_array(mysqli_query($con,"select * from 追加商品 where 訂單編號='{$_POST['a']}' and 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'"))['追加商品數量'];
                            if($n<0){
                                echo "<script>alert('商品庫存不足！');</script>";
                                echo "<script>window.location.href='buhuo.php'</script>";
                            }
                            mysqli_query($con,"update 商品 set 庫存數量='{$n}' where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}'");
                            mysqli_query($con,"update 追加商品 set 追加商品數量='{$_POST[$gn]}' where 訂單編號='{$_POST['a']}' and 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}';");
                        }
                        
                    }
                    $gs=mysqli_fetch_array($g);
                }
                $aa=mysqli_fetch_array(mysqli_query ( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}';"))['派車單編號'];
                echo "<input type='hidden' name='a' value='",$aa,"'><script>form.submit()</script>";
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>