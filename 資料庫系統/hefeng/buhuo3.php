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
        <form name="form" method="post" action="buhuodan.php">
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
                $c=mysqli_query( $con,"select * from 貨車;");
                $today = substr(date("Ymd", time()+7*60*60),2,6)."001";
                $today=(int)($today);
                while(mysqli_fetch_array(mysqli_query ( $con,"select * from 補貨單 where 補貨單編號='{$today}';"))){
                    $today++;
                }
                if(!isset($_POST['a'])){
                    mysqli_close ( $con );
                    echo "<script>window.location.href='buhuo2.php'</script>";
                }
                $mcn=$_POST['a'];
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
                    echo "<script>window.location.href='buhuo2.php'</script>";
                }
                if(isset($_POST['d'])){
                    $cs=mysqli_fetch_array($c);
                    $i=true;
                    while($cs){
                        if($cs['派車狀態']==0){
                            mysqli_query($con,"update 貨車 set 派車狀態=1 where 車牌='{$cs['車牌']}';");
                            $t=date("Y-m-d", time()+7*60*60)." ".$_POST['d'];
                            mysqli_query($con,"insert into 補貨單(補貨單編號,補貨的廠商,車牌,派車時間,補貨的帳號) values('{$today}','{$mcn}','{$cs['車牌']}','{$t}','{$_SESSION['mc']}');");
                            $i=false;
                            break;
                        }
                        $cs=mysqli_fetch_array($c);
                    }
                    if($i){
                        echo "<script>alert('沒有貨車是空閒的！');</script>";
                        echo "<script>window.location.href='buhuo2.php'</script>";
                    }
                    
                }else{
                    mysqli_query($con,"insert into 補貨單(補貨單編號,補貨的廠商,補貨的帳號) values('{$today}','{$mcn}','{$_SESSION['mc']}');");
                }
                $g=mysqli_query( $con,"select * from 商品 where 供貨廠商='{$mcn}';");
                $gs=mysqli_fetch_array($g);
                while($gs){
                    $gn=$gs['商品名稱'].$gs['規格'].$gs['單位'];
                    if(isset($_POST[$gn])&&$_POST[$gn]>0){
                        mysqli_query($con,"insert into 商補 values('{$today}','{$gs['商品名稱']}','{$gs['規格']}','{$gs['單位']}','{$_POST[$gn]}');");
                    }
                    $gs=mysqli_fetch_array($g);
                }
                echo "<input type='hidden' name='a' value='",$today,"'><script>form.submit()</script>";
            ?>
            
        </form>
    </main>
<?php
mysqli_close ( $con ); 
?> 

</body> 
</html>