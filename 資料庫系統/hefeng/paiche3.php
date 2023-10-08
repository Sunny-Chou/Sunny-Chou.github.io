<!doctype html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <title>派車</title>
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
        <form name="form" method="post" action="paichedan.php">
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
                $today = substr(date("Ymd", time()+7*60*60),2,6)."001";
                $today=(int)($today);
                while(mysqli_fetch_array(mysqli_query ( $con,"select * from 派車單 where 派車單編號='{$today}';"))){
                    $today++;
                }
                $c=mysqli_query( $con,"select * from 貨車;");
                $cs=mysqli_fetch_array($c);
                $i=true;
                while($cs){
                    if($cs['派車狀態']==0){
                        mysqli_query($con,"update 貨車 set 派車狀態=1 where 車牌='{$cs['車牌']}';");
                        $i=false;
                        break;
                    }
                    $cs=mysqli_fetch_array($c);
                }
                if($i){
                    echo "<script>alert('沒有貨車是空閒的！');</script>";
                    echo "<script>window.location.href='paiche.php'</script>";
                }
                $t=date("Y-m-d", time()+7*60*60)." ".$_POST['t'];
                mysqli_query ( $con,"insert into 派車單 values('{$today}','{$cs['車牌']}','{$t}','{$_SESSION['mc']}',0);");
                $a = mysqli_query ( $con,"select * from 訂單 where 訂單備貨狀態=1 and 配送方式=1 and 配送日期='{$_POST['a']}' and 派車單編號 is null;");
                $aa=mysqli_fetch_array($a);
                while($aa){
                    mysqli_query ( $con,"update 訂單 set 派車單編號='{$today}' where 訂單編號='{$aa['訂單編號']}';");
                    $aa=mysqli_fetch_array($a);
                }
                echo "<input type='hidden' name='a' value='",$today,"'><script>form.submit()</script>";
            }else{
                mysqli_close ( $con );
                echo "<script>window.location.href='paiche2.php'</script>";
            }
            ?>
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>