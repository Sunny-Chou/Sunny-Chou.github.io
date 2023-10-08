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
        <form name="form" method="post" action="gaiorshan_2.php">
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
                echo "<input type='hidden' name='a' value='",$as,"'><script>form.submit()</script>";
            ?>
            
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>