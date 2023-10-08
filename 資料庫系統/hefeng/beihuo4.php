<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>備貨</title>
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
            div{
                text-align: center;
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
            <form name="form" method="post" action="beihuodan.php">
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
            if(!isset($_POST['a'])||!mysqli_fetch_array(mysqli_query( $con,"select * from 訂單 where 訂單編號='{$_POST['a']}' and 訂單備貨狀態=0;"))){
                mysqli_close ( $con );
                echo "<script>window.location.href='beihuo3.php'</script>";
            }
            $i=true;
            $g=mysqli_query( $con,"select * from 購買 where 訂單編號='{$_POST['a']}';");
            $gs=mysqli_fetch_array($g);
            while($gs){
                if(mysqli_fetch_array(mysqli_query( $con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}';"))['庫存數量']<$gs['購買商品數量']){
                    $i=false;
                    break;
                }
                $gs=mysqli_fetch_array($g);
            }
            if($i){
                $g=mysqli_query( $con,"select * from 購買 where 訂單編號='{$_POST['a']}';");
                $gs=mysqli_fetch_array($g);
                mysqli_query ( $con,"update 訂單 set 訂單備貨狀態=1 where 訂單編號='{$_POST['a']}';");
                while($gs){
                    $gg=mysqli_fetch_array(mysqli_query( $con,"select * from 商品 where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}' and 單位='{$gs['單位']}';"))['庫存數量']-$gs['購買商品數量'];
                    mysqli_query ( $con,"update 商品 set 庫存數量='{$gg}' where 商品名稱='{$gs['商品名稱']}' and 規格='{$gs['規格']}'and 單位='{$gs['單位']}';");
                    $gs=mysqli_fetch_array($g);
                }
            }else{
                echo "<script>alert('庫存數量不足！');</script>";
                mysqli_close ( $con );
                echo "<script>window.location.href='beihuo3.php'</script>";
            }
            echo "<input type='hidden' name='a' value='",$_POST['a'],"'><script>form.submit()</script>";
        ?>
        </form>
        <?php
            mysqli_close ( $con ); 
        ?> 
        <script>form.submit();</script>
    </main>

</body> 
</html>