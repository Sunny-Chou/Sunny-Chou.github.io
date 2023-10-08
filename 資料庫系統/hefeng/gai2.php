<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
    </head> 
    <body>
    <main>
        <form name="form" method="post" action="gaiorshan2.php">
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
                    echo "<script>window.location.href='employeeFunctionSelect.php'</script>";
                }
                $a=mysqli_query( $con,"select * from 訂單;");
                $as=mysqli_fetch_array($a);
                $i=true;
                while($as){
                    if(isset($_POST[$as['訂單編號']])){
                        $as=$as['訂單編號'];
                        $i=false;
                       break; 
                    }
                    $as=mysqli_fetch_array($a);
                }
                if($i){
                    mysqli_close ( $con );
                    echo "<script>window.location.href='gaiorshan0.php'</script>";
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
                    echo "<script>window.location.href='gaiorshan.php'</script>";
                }
                mysqli_query( $con,"delete from 購買 where 訂單編號='{$as}';");
                $g=mysqli_query( $con,"select * from 商品;");
                $gs=mysqli_fetch_array($g);
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        mysqli_query($con,"insert into 購買 values('{$as}','{$gs['商品名稱']}','{$gs['規格']}','{$gs['單位']}','{$_POST[$gn]}');");
                    }
                    $gs=mysqli_fetch_array($g);
                }
                mysqli_query($con,"update 訂單 set 建立的帳號='{$_SESSION['mc']}' where 訂單編號='{$as}';");
                echo "<input type='hidden' name='a' value='",$as,"'><script>form.submit()</script>";
            ?>
            
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>