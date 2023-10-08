<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
    </head> 
    <body>
    <main>
        <form name="form" method="post" action="gaiorshan.php">
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
                    echo "<script>window.location.href='gaiorshan.php'</script>";
                }
                mysqli_query( $con,"delete from 購買 where 訂單編號='{$as}';");
                mysqli_query( $con,"delete from 訂單 where 訂單編號='{$as}';");
                echo "<script>form.submit()</script>";
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>