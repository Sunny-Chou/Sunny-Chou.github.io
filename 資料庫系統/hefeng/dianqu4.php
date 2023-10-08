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
        <form name="form" method="post" action="dianqu.php">
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
                if(!isset($_POST['a'])){
                    mysqli_close ( $con ); 
                    echo "<script>window.location.href='dianqu3.php'</script>";
                }
                mysqli_query( $con,"update 訂單 set 訂單狀態=1,店取交貨的帳號='{$_SESSION['mc']}' where 訂單編號='{$_POST['a']}';");
                echo "<input type='hidden' name='a' value='",$_POST['a'],"'><script>form.submit()</script>";
            ?>
            
        </form>
    </main>
    <?php
        mysqli_close ( $con ); 
    ?> 
</body> 
</html>